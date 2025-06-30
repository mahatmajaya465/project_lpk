<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PendaftaranTransformer extends JsonResource
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
            'peserta_id' => $this->peserta_id,
            'kode_pendaftaran' => $this->kode_pendaftaran,
            'program_kursus_id' => $this->program_kursus_id,
            'kelas_kursus_id' => $this->kelas_kursus_id,
            'peserta' => new PesertaTransformer($this->peserta),
            'program' => new ProgramTransformer($this->program),
            'kelas' => new KelasTransformer($this->kelas),
        ];
    }
}
