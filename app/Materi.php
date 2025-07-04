<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    use SoftDeletes;
     
    protected $table = 'materi_kursus';

    protected $fillable = [
        'kode_materi',
        'nama',
        'deskripsi',
        'kategori',
        'silabus'
    ];

    public function list($request)
    {
        $materi = $this->whereNull('deleted_at');

        $search = $request->search;

        if ($search) {
            $materi = $materi->where(function ($q) use ($search) {
                $q->where('kode_materi', 'LIKE', "%$search%")
                    ->orWhere('nama', 'LIKE', "%$search%")
                    ->orWhere('deskripsi', 'LIKE', "%$search%")
                    ->orWhere('kategori', 'LIKE', "%$search%");
            });
        }

        if($request->kelas_id){
            $jadwal = Jadwal::where('kelas_kursus_id', $request->kelas_id)->get()->pluck('materi_id');
            $materi = $materi->whereIn('id', $jadwal);
        }

        return $materi->paginate(100);
    }

    public function store($request): Materi
    {
        $materi = new Materi();
        $materi->kode_materi = $request->kode_materi;
        $materi->nama = $request->nama;
        $materi->deskripsi = $request->deskripsi;
        $materi->kategori = $request->kategori;
        $materi->silabus = $request->silabus;

        $materi->save();

        return $materi;
    }
    
    public function updateMateri($request): Materi
    {
        $materi = $this;
        $materi->kode_materi = $request->kode_materi;
        $materi->nama = $request->nama;
        $materi->deskripsi = $request->deskripsi;
        $materi->kategori = $request->kategori;
        $materi->silabus = $request->silabus;

        $materi->save();

        return $materi;
    }
}
