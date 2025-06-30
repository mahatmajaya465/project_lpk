<?php

namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use SoftDeletes;
    
    protected $table = 'jadwal';

    protected $fillable = [
        'kelas_kursus_id',
        'instruktur_id',
        'materi_id',
        'tgl_mulai',
        'tgl_selesai',
        'status',
    ];

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'instruktur_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_kursus_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id');
    }

    public function list($request): LengthAwarePaginator
    {
        $jadwal = $this->whereNull('deleted_at')->where('kelas_kursus_id', $request->kelas_kursus_id);

        return $jadwal->paginate(100);
    }
    
    public function listAbsensi($request): LengthAwarePaginator
    {
        if(auth()->user()->roles == "super_admin") {
            $jadwal = $this->whereNull('deleted_at');
        } else {
            $instruktur = Instruktur::where('user_id', $request->user()->id)->first();
            $jadwal = $this->whereNull('deleted_at')->where('instruktur_id', $instruktur->id);
        }

        return $jadwal->paginate(100);
    }

    public function store($request): Jadwal
    {
        $kelas = new Jadwal();
        $kelas->kelas_kursus_id = $request->kelas_kursus_id;
        $kelas->instruktur_id = $request->instruktur_id;
        $kelas->materi_id = $request->materi_id ?? null;
        $kelas->tgl_mulai = $request->tgl_mulai;
        $kelas->tgl_selesai = $request->tgl_selesai;
        $kelas->status = $request->status ?? 'active';

        $kelas->save();

        return $kelas;
    }

    public function updateKelas($request): Jadwal
    {
        $kelas = $this;
        $kelas->kelas_kursus_id = $request->kelas_kursus_id;
        $kelas->instruktur_id = $request->instruktur_id;
        $kelas->materi_id = $request->materi_id ?? null;
        $kelas->tgl_mulai = $request->tgl_mulai;
        $kelas->tgl_selesai = $request->tgl_selesai;
        $kelas->status = $request->status ?? 'active';

        $kelas->save();

        return $kelas;
    }
}
