<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PickupRequestCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data" => $this->collection->transform(function($pickup){
                return [
                    'id' => $pickup->id,
                    'shop_name' => $pickup->merchant->business_name,
                    'contact' => $pickup->shop->phone,
                    'pickup_location' => $pickup->shop->pickup_location,
                    'quantity' => $pickup->total_parcel,
                    'status' => $pickup->status,
                    'action' => ['edit'],
                ];
            }),
            "columns" => [
                [
                    'label' => 'ID',
                    'name' => 'id'
                ],
                [
                    'label' => 'Shop Name',
                    'name' => 'shop_name'
                ],
                [
                    'label' => 'Contact',
                    'name' => 'contact'
                ],
                [
                    'label' => 'Pickup Location',
                    'name' => 'pickup_location'
                ],
                [
                    'label' => 'Quantity',
                    'name' => 'quantity'
                ],
                [
                    'label' => 'Status',
                    'name' => 'status'
                ],
                [
                    'label' => 'Action',
                    'name' => 'action'
                ],
            ]
        ];
    }
}
