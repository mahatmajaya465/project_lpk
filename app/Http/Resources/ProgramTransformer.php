<?php

namespace App\Http\Resources;

use App\Traits\FormatRupiah;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramTransformer extends JsonResource
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
        return [
            'id' => $this->id,
            'kode_program' => strtoupper($this->kode_program),
            'status_strtoupper' => strtoupper($this->status),
            'status' => $this->status,
            'nama_program' => $this->nama_program,
            'harga_rp' => $this->rupiah($this->harga),
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
        ];
    }
}
