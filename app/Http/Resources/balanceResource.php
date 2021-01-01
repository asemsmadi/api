<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class balanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
     return   [
            'id' => $this->id,
            'amount' => $this->amount,
            'note' => $this->note,
            'DateRun' => $this->DateRun,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'userName' => $this->user->user->name,
            'email' => $this->user->user->email,
        ];

    }
}
