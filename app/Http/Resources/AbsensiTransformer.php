<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiTransformer extends JsonResource
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
            'user_id' => $this->user_id,
            'jadwal_id' => $this->jadwal_id,
            'tgl_absensi' => $this->tgl_absensi,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'lokasi' => $this->lokasi,
            'type' => $this->type,
            'type_format' => $this->type == 'clock_in' ? 'Clock In' : 'Clock Out',
            'user' => new UsersTransformer($this->user)
        ];
    }
}
