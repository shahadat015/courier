<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EntryParcelCollection extends ResourceCollection
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
            "data" => $this->collection->transform(function($merchant){
                return [
                    'id' => $merchant->id,
                    'owner' => $merchant->name,
                    'merchant' => $merchant->business_name,
                    'contact' => $merchant->phone,
                    'pickup_location' => $merchant->pickup_location,
                    'action' => ['add-parcel']
                ];
            }),
            "columns" => [
                [
                    'label' => 'Merchant',
                    'name' => 'merchant'
                ],
                [
                    'label' => 'Owner Name',
                    'name' => 'owner'
                ],
                [
                    'label' => 'Contact',
                    'name' => 'contact'
                ],
                [
                    'label' => 'Picup Location',
                    'name' => 'pickup_location'
                ],
                [
                    'label' => 'Action',
                    'name' => 'action'
                ],
            ]
        ];
    }
}
