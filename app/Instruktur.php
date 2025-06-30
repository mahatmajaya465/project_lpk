<?php

namespace App;

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
}
