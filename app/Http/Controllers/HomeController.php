<?php

namespace App\Http\Controllers;

use App\Instruktur;
use App\Kelas;
use App\Pembayaran;
use App\Peserta;
use App\Program;
use App\Traits\FormatRupiah;
use Carbon\Carbon;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    use FormatRupiah;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function analysis(Request $request)
    {
        try {
            $periode = $request->periode ?? date('Y-m');

            // Active participants count (created_at <= akhir bulan dari periode)
            $peserta_aktif = Peserta::where('status', 'active')
                ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth());
            if (auth()->user()->roles != 'super_admin') {
                $peserta_aktif->where('user_id', auth()->user()->id);
            }
            $peserta_aktif = $peserta_aktif->count();

            // Active classes count (created_at <= akhir bulan dari periode)
            $kelas_aktif = 0;
            if (auth()->user()->roles == 'super_admin') {
                $kelas_aktif = Kelas::where('status', 'active')
                    ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())
                    ->count();
            } else {
                $kelas_aktif = Kelas::where('status', 'active')
                    ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())
                    ->whereHas('peserta', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    })->count();
            }

            // Payments received (filter by periode if provided)
            $pembayaranQuery = Pembayaran::where('status', 'settlement');
            if ($periode) {
                $pembayaranQuery->where('created_at', 'like', "$periode%");
            }
            if (auth()->user()->roles != 'super_admin') {
                $peserta = Peserta::where('user_id', auth()->user()->id)->first();
                $pendaftaranIds = $peserta ? $peserta->pendaftaran->pluck('id') : [];
                $pembayaranQuery->whereIn('pendaftaran_id', $pendaftaranIds);
            }
            $pembayaran = $pembayaranQuery->sum('nominal');

            // Instructor salaries (filter by periode)
            $gaji_instruktur = 0;
            if( auth()->user()->roles != 'super_admin') {
                $instruktur = Instruktur::where('user_id', auth()->user()->id)->get();
            } else {
                $instruktur = Instruktur::all();
            }
            foreach ($instruktur as $item) {
                $gaji = $item->getGajiInstruktur($item, $periode);
                $gaji_instruktur += $gaji['totalGaji'];
            }

            // Participants per class
            $kelasWithPeserta = Kelas::withCount('peserta')
                ->where('status', 'active')
                ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())
                ->get()
                ->map(function ($kelas) {
                    return [
                        'nama_kelas' => $kelas->nama_kelas,
                        'peserta_count' => $kelas->where('status', 'active')->peserta_count
                    ];
                });

            // Participants per program
            $programsWithClasses = Program::where('status', 'active')->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())->with(['kelas' => function ($query) {
                $query->where('status', 'active')->withCount('peserta');
            }])->get()->map(function ($program) {
                return [
                    'nama_program' => $program->nama_program,
                    'kelas' => $program->kelas->map(function ($kelas) {
                        return [
                            'nama_kelas' => $kelas->nama_kelas,
                            'peserta_count' => $kelas->peserta_count
                        ];
                    })
                ];
            });

            return response()->json([
                'data' => [
                    'peserta_aktif' => $peserta_aktif,
                    'kelas_aktif' => $kelas_aktif,
                    'pembayaran_diterima' => $pembayaran,
                    'gaji_instruktur' => $gaji_instruktur,
                    'peserta_per_kelas' => [
                        'labels' => $kelasWithPeserta->pluck('nama_kelas'),
                        'data' => $kelasWithPeserta->pluck('peserta_count'),
                    ],
                    'peserta_per_program' => $programsWithClasses
                ],
                'error' => false,
                'message' => 'Analysis success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
