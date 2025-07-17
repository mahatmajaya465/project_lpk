<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Penilaian;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF; // Assuming you have a PDF package installed, e.g., barryvdh

class SertifikatController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        $query = Penilaian::with(['user', 'program', 'kelas'])
            ->select(
                'user_id',
                'program_id',
                'kelas_kursus_id',
                \DB::raw('AVG(nilai) as rata_rata_nilai'),
                \DB::raw('COUNT(*) as total_materi')
            )
            ->where('program_id', $request->program_id)
            ->where('kelas_kursus_id', $request->kelas_id)
            ->groupBy('user_id', 'program_id', 'kelas_kursus_id');

        if (auth()->user()->roles == 'student') {
            $userId = auth()->user()->id;
            $query->where('user_id', $userId);
        }

        $results = $query->get();

        // Format response
        $formattedResults = $results->map(function ($item) {
            return [
                'user' => $item->user,
                'program' => $item->program,
                'kelas' => $item->kelas,
                'rata_rata_nilai' => round($item->rata_rata_nilai, 2),
                'total_materi' => $item->total_materi,
                'keterangan' => $this->getKeteranganNilai($item->rata_rata_nilai)
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedResults
        ]);
    }

    private function getKeteranganNilai($nilai)
    {
        if ($nilai >= 85) return 'Sangat Baik';
        if ($nilai >= 70) return 'Baik';
        if ($nilai >= 60) return 'Cukup';
        return 'Perlu Perbaikan';
    }

    public function download(Request $request)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        // Ambil data penilaian
        $penilaian = Penilaian::with(['user', 'program', 'kelas'])
            ->select(
                'user_id',
                'program_id',
                'kelas_kursus_id',
                \DB::raw('AVG(nilai) as rata_rata_nilai'),
                \DB::raw('COUNT(*) as total_materi')
            )
            ->where('program_id', $request->program_id)
            ->where('kelas_kursus_id', $request->kelas_id)
            ->groupBy('user_id', 'program_id', 'kelas_kursus_id')
            ->firstOrFail();

        // Format data untuk template
        $data = [
            'logo' => 'https://lkpsaraswati.com/wp-content/uploads/2023/05/logo-saraswati.png',
            'institution' => 'LKP SARASWATI KOMPUTER',
            'address' => 'Jl. Raya Sesetan No. 122, Denpasar, Bali',
            'certificate_title' => 'SERTIFIKAT KOMPETENSI',
            'member_text' => 'MEMBERMAN',
            'recipient' => [
                'name' => $penilaian->user->name,
                'registration' => 'REG-' . $penilaian->program->kode_program . "" . $penilaian->user->id . '-' . Carbon::parse($penilaian->kelas->tgl_selesai)->format('Ym')
            ],
            'course' => [
                'name' => $penilaian->kelas->nama_kelas,
                'program' => $penilaian->program->nama_program,
                'duration' => $penilaian->kelas->jumlah_jam . ' Jam Pelajaran',
                'nilai' => round($penilaian->rata_rata_nilai, 2),
                'keterangan' => $this->getKeteranganNilai($penilaian->rata_rata_nilai),
                'period' => Carbon::parse($penilaian->kelas->tgl_mulai)->format('d F Y') . ' - ' . Carbon::parse($penilaian->kelas->tgl_selesai)->format('d F Y')
            ],
            'signature' => [
                'title' => 'PIMPINAN LEMBAGA',
                'name' => 'ITD RAMAR PIMPINAN'
            ],
            'date' => Carbon::now()->format('d F Y'),
            'nomor_sertifikat' => 'CER-' . $penilaian->program->kode_program . "" . $penilaian->user->id . '-' . Carbon::parse($penilaian->kelas->tgl_selesai)->format('Ym')
        ];


        $pdf = Pdf::loadView('sertifikat.template', $data);
        $pdf->setPaper('A4', 'landscape');
        $dompdf->set_option('margin_top', '5mm');
        $dompdf->set_option('margin_right', '5mm');
        $dompdf->set_option('margin_bottom', '5mm');
        $dompdf->set_option('margin_left', '5mm');

        // return $pdf->stream();

        return $pdf->download($data['nomor_sertifikat'] . '.pdf');
    }
}
