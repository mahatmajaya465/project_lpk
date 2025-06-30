<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Peserta;
use App\Projects;
use App\Services;
use App\Testimonials;
use App\Traits\FormatRupiah;
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
            $peserta_aktif = Peserta::where('status', 'active')->count();
            $kelas_aktif = Kelas::where('status', 'active')->count();
            
            return response()->json([
                'data' => [
                    'peserta_aktif' => $this->rupiah($peserta_aktif),
                    'kelas_aktif' => $this->rupiah($kelas_aktif),
                    'pembayaran_diterima' => $this->rupiah(0),
                    'gaji_instruktur' => $this->rupiah(0),
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
