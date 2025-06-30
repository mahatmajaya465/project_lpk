<?php

namespace App\Http\Resources;

use App\Traits\FormatDate;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasTransformer extends JsonResource
{
    use FormatDate;
    
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
            'program_kursus_id' => $this->program_kursus_id,
            'kode_kelas' => $this->kode_kelas,
            'nama_kelas' => $this->nama_kelas,
            'tgl_mulai_indo' => $this->tanggalIndonesian($this->tgl_mulai),
            'tgl_selesai_indo' => $this->tanggalIndonesian($this->tgl_selesai),
            'tgl_mulai' => date('Y-m-d', strtotime($this->tgl_mulai)),
            'tgl_selesai' => date('Y-m-d', strtotime($this->tgl_selesai)),
            'tgl_pendaftaran' => date('Y-m-d', strtotime($this->tgl_pendaftaran)),
            'tgl_penutupan' => date('Y-m-d', strtotime($this->tgl_penutupan)),
            'deskripsi' => $this->deskripsi,
            'jumlah_peserta' => $this->jumlah_peserta,
            'status' => $this->status,
            'program' => new ProgramTransformer($this->program),
        ];
    }
}
