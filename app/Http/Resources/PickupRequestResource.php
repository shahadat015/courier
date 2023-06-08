<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PickupRequestResource extends JsonResource
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
            'merchant_name' => $this->shop->business_name,
            'contact' => $this->shop->phone,
            'Pickup_location' =>  $this->shop->pickup_location,
            'total_parcel' =>  $this->total_parcel,
            'created_at' =>  $this->created_at,
            'updated_at' =>  $this->updated_at,
            'status' =>  $this->status,
            'shop_id' =>  $this->shop_id,
            'note' =>  $this->note,
            'shops' => $this->merchant->shops,
        ];
    }
}
