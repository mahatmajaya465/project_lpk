<?php

namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pendaftaran extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'peserta_id',
        'kode_pendaftaran',
        'program_kursus_id',
        'kelas_kursus_id',
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_kursus_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_kursus_id');
    }

    public function list($request): LengthAwarePaginator
    {
        $auth = auth()->user();

        $pendaftaran = $this->whereNull('deleted_at');

        $pesertaAll = Peserta::whereNull('deleted_at')->pluck('id')->toArray();

        if ($auth->roles == 'student') {
            $peserta = Peserta::where('user_id', $auth->id)->first();
            $pendaftaran = $pendaftaran->where('peserta_id', $peserta->id);
        }

        $pendaftaran = $pendaftaran->whereIn('peserta_id', $pesertaAll);

        $search = $request->search;

        if ($search) {
            $pendaftaran = $pendaftaran->where(function ($q) use ($search) {
                $q->where('kode_pendaftaran', 'LIKE', "%$search%");
            });
        }

        if ($request->periode) {
            $pendaftaran = $pendaftaran->where('created_at', 'LIKE', "%$request->periode%");
        }

        if ($request->status) {
            $pendaftaran = $pendaftaran->where('status', $request->status);
        }

        if ($request->pagination == 'false') {
            $per_page = PHP_INT_MAX;
        } else {
            $per_page = $request->per_page ?? 100;
        }

        return $pendaftaran->paginate($per_page);
    }

    public function store($request): Pendaftaran
    {
        $pendaftaran = new Pendaftaran();
        $pendaftaran->peserta_id = $request->peserta_id;
        // $pendaftaran->kode_pendaftaran = $request->kode_pendaftaran;
        $pendaftaran->kode_pendaftaran = "PD-" . strtoupper(Str::random(6));
        $pendaftaran->program_kursus_id = $request->program_kursus_id;
        $pendaftaran->kelas_kursus_id = $request->kelas_kursus_id;
        $pendaftaran->status = $request->status ?? 'pending';

        $pendaftaran->save();

        return $pendaftaran;
    }

    public function updatePendaftaran($request): Pendaftaran
    {
        $pendaftaran = $this;
        $pendaftaran->peserta_id = $request->peserta_id;
        // $pendaftaran->kode_pendaftaran = $request->kode_pendaftaran;
        $pendaftaran->program_kursus_id = $request->program_kursus_id;
        $pendaftaran->kelas_kursus_id = $request->kelas_kursus_id;
        $pendaftaran->status = $request->status ?? 'pending';

        $pendaftaran->save();

        return $pendaftaran;
    }
}
