<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruktur extends Model
{
    use SoftDeletes;

    protected $table = 'instruktur';

    protected $fillable = [
        'user_id',
        'keahlian',
        'pendidikan',
        'honor_perjam',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function list($request): LengthAwarePaginator
    {
        $instruktur = $this->with('user')
            ->whereHas('user', function ($query) {
                $query->where('roles', 'instruktur');
            });

        $instruktur = $instruktur->whereNull('deleted_at');

        $search = $request->search;

        if ($search) {
            $instruktur = $instruktur->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhere('keahlian', 'like', '%' . $search . '%')
                    ->orWhere('pendidikan', 'like', '%' . $search . '%')
                    ->orWhere('honor_perjam', 'like', '%' . $search . '%');
            });
        }

        return $instruktur->paginate(100);
    }

    public function store($request): Instruktur
    {
        $instruktur = new Instruktur();
        $instruktur->user_id = $request->user_id;
        $instruktur->keahlian = $request->keahlian;
        $instruktur->pendidikan = $request->pendidikan;
        $instruktur->honor_perjam = $request->honor_perjam;

        $instruktur->save();

        return $instruktur;
    }

    public function updateInstruktur($request): Instruktur
    {
        $instruktur = $this;
        $instruktur->keahlian = $request->keahlian;
        $instruktur->pendidikan = $request->pendidikan;
        $instruktur->honor_perjam = $request->honor_perjam;

        $instruktur->save();

        return $instruktur;
    }

    public function getGajiInstruktur($instruktur, $periode): array
    {
        // Get all jadwals for this instruktur in the periode
        $jadwals = Jadwal::where('instruktur_id', $instruktur->id)
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

        return [
            'totalJam' => $totalJam,
            'totalMenit' => $totalMenit,
            'totalGaji' => $totalGaji,
            'detailJadwals' => $detailJadwals
        ];
    }
}
