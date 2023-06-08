<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParcelCollection extends ResourceCollection
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
                    'invoice' => $parcel->invoice_no,
                    'shop' => $parcel->merchant->business_name,
                    'customer' => $parcel->customer_name . '<br>'. $parcel->customer_phone . '<br>' . $parcel->customer_address,
                    'status' => $parcel->status,
                    'cod' => $parcel->collection_amount,
                    'note' => $parcel->parcel_note,
                    'action' => auth()->user()->isAdmin() ? ['edit'] : ['show'],
                ];
            }),
            "columns" => [
                [
                    'label' => 'ID',
                    'name' => 'id'
                ],
                [
                    'label' => 'Invoice',
                    'name' => 'invoice'
                ],
                [
                    'label' => 'Shop',
                    'name' => 'shop'
                ],
                [
                    'label' => 'Customer',
                    'name' => 'customer'
                ],
                [
                    'label' => 'Status',
                    'name' => 'status'
                ],
                [
                    'label' => 'COD',
                    'name' => 'cod'
                ],
                [
                    'label' => 'Note',
                    'name' => 'note'
                ],
                [
                    'label' => 'Action',
                    'name' => 'action'
                ],
            ]
        ];
    }
}
