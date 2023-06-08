<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'present_address' => $this->present_address,
            'permanent_address' => $this->permanent_address,
            'status' => $this->status,
            'performance' => [
                'performance' => 0,
                'cancel_rate' => 0,
                'delivery_rate' => 0,
                'parcel_delivered' => $this->riderParcelDelivered(),
            ]
        ];
    }
}
