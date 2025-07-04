<?php

namespace App\Http\Controllers;

use App\Instruktur;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function gajiInstruktur(Request $request)
    {
        $periode = $request->periode ?? date('Y-m');
        $periode = date('Y-m', strtotime($periode));

        $instruktur = Instruktur::with('user')->find($request->instruktur_id);
       
        if (!$instruktur) {
            return response()->json(['message' => 'Instruktur tidak ditemukan'], 404);
        }

        $data = $instruktur->getGajiInstruktur($instruktur, $periode);

        return response()->json([
            'instruktur' => $instruktur,
            'jadwals' => $data['detailJadwals'],
            'periode' => $periode,
            'total_jam_kerja' => [
                'jam' => $data['totalJam'],
                'menit' => $data['totalMenit']
            ],
            'gaji' => $data['totalGaji'],
            'gaji_per_jam' => $instruktur->honor_perjam ?? 0,
            'total_jam' => $data['totalJam'] . " jam " . $data['totalMenit'] . " menit",
        ]);
    }
}
