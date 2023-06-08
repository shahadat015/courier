<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RiderParcelCollection extends ResourceCollection
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
                    'date' => $parcel->created_at,
                    'total_parcel' => $parcel->total_parcel,
                    'collection_amount' => $parcel->collection_amount,
                    'status' => $parcel->status,
                    'action' => [ 'edit', 'show'],
                ];
            }),
            "columns" => [
                [
                    'label' => 'ID',
                    'name' => 'id'
                ],
                [
                    'label' => 'Date',
                    'name' => 'date'
                ],
                [
                    'label' => 'Collection Amount',
                    'name' => 'collection_amount'
                ],
                [
                    'label' => 'Total Parcel',
                    'name' => 'total_parcel'
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
