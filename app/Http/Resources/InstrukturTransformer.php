<?php

namespace App\Http\Resources;

use App\Traits\FormatRupiah;
use Illuminate\Http\Resources\Json\JsonResource;

class InstrukturTransformer extends JsonResource
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
            'user_id' => $this->user_id,
            'keahlian' => $this->keahlian,
            'pendidikan' => $this->pendidikan,
            'pendidikan_strtoupper' => strtoupper($this->pendidikan),
            'honor_perjam' => $this->honor_perjam,
            'honor_perjam_rp' => $this->rupiah($this->honor_perjam),
            'user' => new UsersTransformer($this->user),
        ];
    }
}
