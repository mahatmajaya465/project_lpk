<?php

namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kelas extends Model
{
    use SoftDeletes;
    
    protected $table = 'kelas_kursus';

    protected $fillable = [
        'program_kursus_id',
        'kode_kelas',
        'nama_kelas',
        'tgl_mulai',
        'tgl_selesai',
        'tgl_pendaftaran',
        'tgl_penutupan',
        'jumlah_peserta',
        'deskripsi',
        'status',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_kursus_id');
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'pendaftaran', 'kelas_kursus_id', 'peserta_id')
                    ->withTimestamps();
    }

    public function list($request): LengthAwarePaginator
    {
        $kelas = $this->whereNull('deleted_at');

        $search = $request->search;

        if ($search) {
            $kelas = $kelas->where(function ($q) use ($search) {
                $q->where('nama_kelas', 'LIKE', "%$search%")
                    ->orWhere('jumlah_peserta', 'LIKE', "%$search%")
                    ->orWhere('deskripsi', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%")
                    ->orWhere('kode_kelas', 'LIKE', "%$search%");
            });
        }

        return $kelas->paginate(100);
    }

    public function store($request): Kelas
    {
        $kelas = new Kelas();
        $kelas->program_kursus_id = $request->program_kursus_id;
        // $kelas->kode_kelas = $request->kode_kelas;
        $kelas->kode_kelas = "KLS-" . strtoupper(Str::random(6));
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->tgl_mulai = $request->tgl_mulai;
        $kelas->tgl_selesai = $request->tgl_selesai;
        $kelas->jumlah_peserta = $request->jumlah_peserta;
        $kelas->status = $request->status ?? 'active';
        $kelas->tgl_pendaftaran = $request->tgl_pendaftaran;
        $kelas->tgl_penutupan = $request->tgl_penutupan;
        $kelas->deskripsi = $request->deskripsi;

        $kelas->save();

        return $kelas;
    }

    public function updateKelas($request): Kelas
    {
        $kelas = $this;
        // $kelas->kode_kelas = $request->kode_kelas;
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->program_kursus_id = $request->program_kursus_id;
        $kelas->tgl_mulai = $request->tgl_mulai;
        $kelas->tgl_selesai = $request->tgl_selesai;
        $kelas->jumlah_peserta = $request->jumlah_peserta;
        $kelas->status = $request->status ?? 'active';
        $kelas->tgl_pendaftaran = $request->tgl_pendaftaran;
        $kelas->tgl_penutupan = $request->tgl_penutupan;
        $kelas->deskripsi = $request->deskripsi;

        $kelas->save();

        return $kelas;
    }

}
