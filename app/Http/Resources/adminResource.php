<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class adminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'admin_id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'name' => $this->user->name,
            'type' => GetUserType($this->user->type),
            'email' => $this->user->email,
        ];
    }
}
