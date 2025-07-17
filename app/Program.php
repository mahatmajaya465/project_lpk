<?php

namespace App;

use App\Traits\FileUpload;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes, FileUpload;
    
    protected $table = 'program_kursus';

    protected $fillable = [
        'kode_program',
        'nama_program',
        'harga',
        'deskripsi',
        'thumbnail',
        'status'
    ];

     public function kelas()
    {
        return $this->hasMany(Kelas::class, 'program_kursus_id');
    }

    public function list($request): LengthAwarePaginator
    {
        $program = $this->whereNull('deleted_at');

        $search = $request->search;

        if ($search) {
            $program = $program->where(function ($q) use ($search) {
                $q->where('nama_program', 'LIKE', "%$search%")
                    ->orWhere('kode_program', 'LIKE', "%$search%")
                    ->orWhere('harga', 'LIKE', "%$search%")
                    ->orWhere('deskripsi', 'LIKE', "%$search%");
            });
        }

        return $program->paginate(100);
    }

    public function store($request): Program
    {

        if ($request->file('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = $this->FileUpload($file, 'thumbnail');
        }

        $program = new Program();
        $program->kode_program = $request->kode_program;
        $program->nama_program = $request->nama_program;
        $program->harga = $request->harga;
        $program->deskripsi = $request->deskripsi;
        $program->status = $request->status ?? 'active';
        $program->thumbnail = $thumbnail ?? null;

        $program->save();

        return $program;
    }

    public function updateProgram($request): Program
    {
        if ($request->file('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnail = $this->FileUpload($file, 'thumbnail');
        }

        $program = $this;
        $program->kode_program = $request->kode_program;
        $program->nama_program = $request->nama_program;
        $program->harga = $request->harga;
        $program->deskripsi = $request->deskripsi;
        $program->status = $request->status ?? 'active';
        
        if (isset($thumbnail)) {
            $program->thumbnail = $thumbnail;
        }

        $program->save();

        return $program;
    }
}
