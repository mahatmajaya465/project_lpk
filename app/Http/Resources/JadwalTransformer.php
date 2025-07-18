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

        $can_absen = false;
        if (
            date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', strtotime($this->tgl_mulai)) &&
            date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($this->tgl_selesai))
        ) {
            $can_absen = true;
        }

        $clock_in = $this->absensi->where('user_id', $user->id)->where('type', 'clock_in')->first() ?? null;

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
            'can_absen' => $can_absen,
            'clock_in' => $clock_in ? true : false
        ];
    }
}
