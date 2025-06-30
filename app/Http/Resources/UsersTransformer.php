<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersTransformer extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'status' => $this->status,
            'last_login' => $this->last_login,
            'roles' => $this->roles,
            'avatar' => $this->avatar ? asset("uploads/$this->avatar") : null
        ];
    }
}
