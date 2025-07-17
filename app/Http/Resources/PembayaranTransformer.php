<?php

namespace App\Http\Resources;

use App\Pendaftaran;
use App\Traits\FormatRupiah;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranTransformer extends JsonResource
{
    use FormatRupiah;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pendaftaran = new PendaftaranTransformer(Pendaftaran::find($this->pendaftaran_id));

        $status = "Menunggu Konfirmasi";
        if ($this->status === 'settlement') {
            $status = "Sudah Dibayar";
        } elseif ($this->status === 'cancel') {
            $status = "Dibatalkan";
        } elseif ($this->status === 'expire') {
            $status = "Kadaluarsa";
        }

        return [
            'id' => $this->id,
            'kode_pembayaran' => $this->kode_pembayaran,
            'tgl_pembayaran' => date('Y-m-d', strtotime($this->tgl_pembayaran)),
            'pendaftaran_id' => $this->pendaftaran_id,
            'nominal' => $this->nominal,
            'nominal_rp' => $this->rupiah($this->nominal),
            'status' => $this->status,
            // 'status_strtoupper' => strtoupper($status),
            'status_strtoupper' => $status,
            'bukti_pembayaran' => $this->bukti_pembayaran,
            'bukti_pembayaran_url' => asset('uploads/' . $this->bukti_pembayaran),
            'metode_pembayaran' => $this->metode_pembayaran,
            'pendaftaran' => $pendaftaran,
            'can_delete' => auth()->user()->roles === 'student' ? false : true,
        ];
    }
}
