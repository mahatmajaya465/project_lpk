<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';

    protected $fillable = [
        'user_id',
        'program_id',
        'kelas_kursus_id',
        'materi_id',
        'nilai',
    ];

    // Pada model Penilaian
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
