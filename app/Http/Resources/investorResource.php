<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Parent_;

class investorResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'UserImage' => $this->UserImage,
            'UserCardImage' => $this->UserCardImage,
            'PassPortImage' => $this->PassPortImage,
            'PassPortNo' => $this->PassPortNo,
            'accept' => $this->accept == 'no' ? 'لا' : 'نعم',
            'sponsorName' => $this->sponsorName,
            'sponsorCardImage' => $this->sponsorCardImage,
            'sponsorPhone' => $this->sponsorPhone,
            'created_at' => $this->created_at,
        ];
    }
}
