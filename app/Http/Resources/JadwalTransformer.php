<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JadwalTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $user = auth()->user();

        if ($user->roles == 'super_admin') {
            $absensi = AbsensiTransformer::collection($this->absensi);
        } else {
            $absensi = AbsensiTransformer::collection($this->absensi->where('user_id', $user->id));
        }

        return [
            'id' => $this->id,
            'kelas_kursus_id' => $this->kelas_kursus_id,
            'instruktur_id' => $this->instruktur_id,
            'tgl_mulai' => $this->tgl_mulai,
            'tgl_selesai' => $this->tgl_selesai,
            'status' => $this->status,
            'status_strtoupper' => strtoupper($this->status),
            'instruktur' => new InstrukturTransformer($this->instruktur),
            'kelas' => new KelasTransformer($this->kelas),
            'materi' => new MateriTransformer($this->materi),
            'absensi' => $absensi,
            'can_absen' => date('Y-m-d') >= date('Y-m-d', strtotime($this->tgl_mulai)) ? true : false,
        ];
    }
}
