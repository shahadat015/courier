<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssignParcelCollection extends ResourceCollection
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
            "data" => $this->collection->transform(function($parcel){
                return [
                    'id' => $parcel->id,
                    'name' => $parcel->customer_name,
                    'invoice_no' => $parcel->invoice_no,
                    'merchant' => $parcel->merchant->name,
                    'phone' => $parcel->customer_phone,
                    'address' => $parcel->customer_address,
                    'collection' => $parcel->collection_amount,
                    'action' => ['add'],
                ];
            }),
            "columns" => [
                [
                    'label' => 'ID',
                    'name' => 'id'
                ],
                [
                    'label' => 'Name',
                    'name' => 'name'
                ],
                [
                    'label' => 'Phone',
                    'name' => 'phone'
                ],
                [
                    'label' => 'Address',
                    'name' => 'address'
                ],
                [
                    'label' => 'Collection',
                    'name' => 'collection'
                ],
                [
                    'label' => 'Action',
                    'name' => 'action'
                ],
            ]
        ];
    }
}
