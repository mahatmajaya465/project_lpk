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
                ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())
                ->count();

            // Active classes count (created_at <= akhir bulan dari periode)
            $kelas_aktif = Kelas::where('status', 'active')
                ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())
                ->count();

            // Payments received (filter by periode if provided)
            $pembayaranQuery = Pembayaran::where('status', 'settlement');
            if ($periode) {
                $pembayaranQuery->where('created_at', 'like', "$periode%");
            }
            $pembayaran = $pembayaranQuery->sum('nominal');

            // Instructor salaries (filter by periode)
            $gaji_instruktur = 0;
            $instruktur = Instruktur::all();
            foreach ($instruktur as $item) {
                $gaji = $item->getGajiInstruktur($item, $periode);
                $gaji_instruktur += $gaji['totalGaji'];
            }

            // Participants per class
            $kelasWithPeserta = Kelas::withCount('peserta')
                ->whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())
                ->get()
                ->map(function ($kelas) {
                    return [
                        'nama_kelas' => $kelas->nama_kelas,
                        'peserta_count' => $kelas->peserta_count
                    ];
                });

            // Participants per program
            $programsWithClasses = Program::whereDate('created_at', '<=', Carbon::parse($periode)->endOfMonth())->with(['kelas' => function ($query) {
                $query->withCount('peserta');
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
