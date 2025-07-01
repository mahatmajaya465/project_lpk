<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes;
    
    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'tgl_absensi',
        'type', // 'type' can be 'clock_in' or 'clock_out'
        'lat',
        'lng',
        'lokasi',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function riwayatAbsensi($request, $id)
    {
        $auth = auth()->user();

        if ($auth->roles != "super_admin") {
            $absensi = self::where('user_id', auth()->user()->id)
                ->when($id, function ($query) use ($id) {
                    return $query->where('jadwal_id', $id);
                })
                ->orderBy('tgl_absensi', 'desc')
                ->get();
        } else {
            $absensi = self::when($id, function ($query) use ($id) {
                return $query->where('jadwal_id', $id);
            })
                ->orderBy('tgl_absensi', 'desc')
                ->get();
        }

        return $absensi;
    }

    public function store($request): Absensi
    {
        $absensi = new Absensi();
        $absensi->user_id = auth()->user()->id;
        $absensi->jadwal_id = $request->id;
        $absensi->tgl_absensi = now();
        $absensi->type = $request->type ?? 'clock_in'; // Default to 'clock_in' if not provided
        $absensi->lat = $request->latitude;
        $absensi->lng = $request->longitude;
        $absensi->lokasi = $request->lokasi;

        $absensi->save();

        return $absensi;
    }
}
