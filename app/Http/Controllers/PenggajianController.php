<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Instruktur;
use App\Jadwal;
use Carbon\Carbon;
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

        // Get all jadwals for this instruktur in the periode
        $jadwals = Jadwal::where('instruktur_id', $request->instruktur_id)
            ->where('tgl_mulai', 'LIKE', "$periode%")
            ->whereNotNull('tgl_mulai')
            ->whereNotNull('tgl_selesai')
            ->get();

        // Filter jadwals that have complete absensi (both check_in and check_out)
        $jadwalsWithCompleteAbsensi = $jadwals->filter(function ($jadwal) {
            $checkIn = Absensi::where('jadwal_id', $jadwal->id)
                ->where('type', 'clock_in')
                ->exists();
            $checkOut = Absensi::where('jadwal_id', $jadwal->id)
                ->where('type', 'clock_out')
                ->exists();
            return $checkIn && $checkOut;
        });

        // Calculate total jam kerja in hours and minutes
        $totalMenitKerja = 0;
        $detailJadwals = [];

        foreach ($jadwalsWithCompleteAbsensi as $jadwal) {
            $start = Carbon::parse($jadwal->tgl_mulai);
            $end = Carbon::parse($jadwal->tgl_selesai);
            $diffInMinutes = $end->diffInMinutes($start);

            $detailJadwals[] = [
                'tgl_mulai' => $jadwal->tgl_mulai,
                'tgl_selesai' => $jadwal->tgl_selesai,
                'jam_kerja' => [
                    'jam' => floor($diffInMinutes / 60),
                    'menit' => $diffInMinutes % 60
                ]
            ];

            $totalMenitKerja += $diffInMinutes;
        }

        $totalJam = floor($totalMenitKerja / 60);
        $totalMenit = $totalMenitKerja % 60;

        // Hitung gaji (misal 100.000 per jam, dengan pembulatan ke atas per 15 menit)
        $gajiPerJam = $instruktur->honor_perjam ?? 0; // Gaji per jam, default 100.000 jika tidak ada
        $totalQuarterHours = ceil($totalMenitKerja / 15); // Pembulatan ke atas per 15 menit
        $totalGaji = ($totalQuarterHours * 15 * $gajiPerJam) / 60;

        return response()->json([
            'instruktur' => $instruktur,
            'jadwals' => $detailJadwals,
            'periode' => $periode,
            'total_jam_kerja' => [
                'jam' => $totalJam,
                'menit' => $totalMenit
            ],
            'gaji' => $totalGaji,
            'gaji_per_jam' => $gajiPerJam,
            'total_jam' => $totalJam . " jam " . $totalMenit . " menit",
        ]);
    }
}
