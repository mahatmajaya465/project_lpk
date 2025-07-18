<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penilaian extends Model
{
    use SoftDeletes;
    
    protected $table = 'penilaian';

    protected $fillable = [
        'user_id',
        'program_id',
        'kelas_kursus_id',
        'materi_id',
        'nilai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_kursus_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}
