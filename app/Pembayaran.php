<?php

namespace App;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use SoftDeletes;

    protected $table = 'pembayaran';

    protected $fillable = [
        'kode_pembayaran',
        'tgl_pembayaran',
        'pendaftaran_id',
        'nominal',
        'status',
        'bukti_pembayaran',
        'metode_pembayaran',
    ];

    public function list($request): LengthAwarePaginator
    {
        $auth = auth()->user();

        $pembayaran = $this->whereNull('deleted_at');

        if ($auth->roles == 'student') {
            $peserta = Peserta::where('user_id', $auth->id)->first();
            $pendaftaranIds = Pendaftaran::where('peserta_id', $peserta->id)->pluck('id');
            $pembayaran = $pembayaran->whereIn('pendaftaran_id', $pendaftaranIds);
        }

        $search = $request->search;

        if ($search) {
            $pembayaran = $pembayaran->where(function ($q) use ($search) {
                $q->where('kode_pembayaran', 'LIKE', "%$search%")
                    ->orWhere('nominal', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%")
                    ->orWhere('metode_pembayaran', 'LIKE', "%$search%");
            });
        }

        if($request->status) {
            $pembayaran = $pembayaran->where('status', $request->status);
        }

        return $pembayaran->paginate(100);
    }

    public function store($request): Pembayaran
    {
        $pembayaran = new Pembayaran();
        $pembayaran->kode_pembayaran = $request->kode_pembayaran;
        $pembayaran->tgl_pembayaran = $request->tgl_pembayaran ?? now();
        $pembayaran->pendaftaran_id = $request->pendaftaran_id;
        $pembayaran->nominal = $request->nominal;
        $pembayaran->status = $request->status ?? 'pending';
        $pembayaran->bukti_pembayaran = $request->bukti_pembayaran;
        $pembayaran->metode_pembayaran = $request->metode_pembayaran;

        $pembayaran->save();

        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);
        if ($pendaftaran) {
            $pendaftaran->status = $request->status ?? 'pending';
            $pendaftaran->save();
        }

        return $pembayaran;
    }

    public function updatePembayaran($request): Pembayaran
    {
        $pembayaran = $this;
        $pembayaran->kode_pembayaran = $request->kode_pembayaran;
        $pembayaran->tgl_pembayaran = $request->tgl_pembayaran ?? now(); 
        $pembayaran->pendaftaran_id = $request->pendaftaran_id;
        $pembayaran->nominal = $request->nominal;
        $pembayaran->status = $request->status ?? 'pending';
        $pembayaran->bukti_pembayaran = $request->bukti_pembayaran;
        $pembayaran->metode_pembayaran = $request->metode_pembayaran;

        $pembayaran->save();

        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);
        if ($pendaftaran) {
            $pendaftaran->status = $request->status ?? 'pending';
            $pendaftaran->save();
        }

        return $pembayaran;
    }
}
