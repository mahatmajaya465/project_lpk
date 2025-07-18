<?php

namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use SoftDeletes;
    
    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'pendidikan_terakhir'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'peserta_id');
    }

    public function list($request): LengthAwarePaginator
    {
        $auth = auth()->user();

        $peserta = $this->with('user')
            ->whereHas('user', function ($query) {
                $query->where('roles', 'student');
            });

        $peserta = $peserta->whereNull('deleted_at');

        if($auth->roles == 'student') {
            $peserta = $peserta->where('user_id', $auth->id);
        }

        $search = $request->search;

        if ($search) {
            $peserta = $peserta->where(function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhere('pendidikan_terakhir', 'like', '%' . $search . '%');
            });
        }

        return $peserta->paginate(100);
    }

    public function store($request): Peserta
    {
        $peserta = new Peserta();
        $peserta->user_id = $request->user_id;
        $peserta->status = $request->status;
        $peserta->pendidikan_terakhir = $request->pendidikan_terakhir;

        $peserta->save();

        return $peserta;
    }

    public function updatePeserta($request): Peserta
    {
        $peserta = $this;
        $peserta->pendidikan_terakhir = $request->pendidikan_terakhir;
        $peserta->status = $request->status;

        $peserta->save();

        return $peserta;
    }
}
