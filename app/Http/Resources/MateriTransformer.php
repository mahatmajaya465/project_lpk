<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MateriTransformer extends JsonResource
{
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
            'kode_materi' => $this->kode_materi,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
            'kategori_ucfirst' => ucfirst($this->kategori),
            'silabus' => $this->silabus,
            'silabus_url' => asset('uploads/' . $this->silabus),
        ];
    }
}
