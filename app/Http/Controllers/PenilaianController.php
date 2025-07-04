<?php

namespace App\Http\Controllers;

use App\Jadwal;
use App\Pendaftaran;
use App\Penilaian;
use App\Peserta;
use App\User;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        $program_id = $request->input('program_id');
        $kelas_id = $request->input('kelas_id');
        $materi_id = $request->input('materi_id');

        // Validasi input
        if (!$program_id || !$kelas_id || !$materi_id) {
            return response()->json(['message' => 'Program, kelas, dan materi harus dipilih'], 400);
        }

        // Dapatkan semua peserta yang terdaftar di kelas ini
        $pesertaKelas = Pendaftaran::where('kelas_kursus_id', $kelas_id)
            ->get();

        if ($pesertaKelas->isEmpty()) {
            return response()->json(['message' => 'Tidak ada peserta di kelas ini'], 404);
        }

        // Proses setiap peserta
        foreach ($pesertaKelas as $peserta) {
            $peserta = Peserta::find($peserta->peserta_id);
            $user = User::find($peserta->user_id);

            // Cek apakah penilaian sudah ada
            $existingPenilaian = Penilaian::where([
                'program_id' => $program_id,
                'kelas_kursus_id' => $kelas_id,
                'materi_id' => $materi_id,
                'user_id' => $user->id
            ])->first();

            // Jika tidak ada, buat penilaian baru
            if (!$existingPenilaian) {
                Penilaian::create([
                    'program_id' => $program_id,
                    'kelas_kursus_id' => $kelas_id,
                    'materi_id' => $materi_id,
                    'user_id' => $peserta->user_id,
                    'nilai' => null, // Nilai default null
                    'created_by' => auth()->id() // Jika menggunakan authentication
                ]);
            }
        }

        // Ambil data penilaian setelah diproses
        $penilaian = Penilaian::with('user')
            ->where([
                'program_id' => $program_id,
                'kelas_kursus_id' => $kelas_id,
                'materi_id' => $materi_id
            ])
            ->get();

        return response()->json($penilaian);
    }

    public function updateBatch(Request $request)
    {
        $data = $request->input('penilaians');

        if (empty($data)) {
            return response()->json(['message' => 'Data tidak boleh kosong'], 400);
        }

        foreach ($data as $item) {
            $penilaian = Penilaian::find($item['id']);
            if ($penilaian) {
                $penilaian->nilai = $item['nilai'];
                $penilaian->save();
            }
        }

        return response()->json(['message' => 'Penilaian berhasil diperbarui']);
    }
}
