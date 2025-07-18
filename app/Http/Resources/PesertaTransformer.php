<?php

namespace App\Http\Resources;

use App\Pendaftaran;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertaTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pendaftaran = Pendaftaran::where('peserta_id', $this->id)->where('status', 'settlement')->first();

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,
            'status' => $this->status,
            'status_strtoupper' => strtoupper($this->status),
            'pendidikan_terakhir_strtoupper' => strtoupper($this->pendidikan_terakhir),
            'user' => new UsersTransformer($this->user),
            'can_delete' => $pendaftaran ? false : true,
        ];
    }
}
