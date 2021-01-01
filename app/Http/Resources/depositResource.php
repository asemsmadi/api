<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class depositResource extends JsonResource
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
            'id' => $this->id,
            'amount' => $this->amount,
            'note' => $this->note,
            'DateDelivery' => $this->DateDelivery,
            'status' => GetDepositState($this->status),
            'created_at' => $this->created_at,
            'userName' => $this->user->user->name,
            'email' => $this->user->user->email,
        ];
    }
}
