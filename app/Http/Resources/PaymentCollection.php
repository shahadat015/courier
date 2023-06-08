<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentCollection extends ResourceCollection
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
            "data" => $this->collection->transform(function($payment){
                return [
                    'id' => $payment->id,
                    'date' => $payment->created_at,
                    'collection_amount' => $payment->collection_amount,
                    'payable_amount' => $payment->total_payable,
                    'surcharge' => $payment->surcharge,
                    'delivery_charge' => $payment->total_delivery_charge,
                    'action' => ['show'],
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
                    'label' => 'Collection',
                    'name' => 'collection_amount'
                ],
                [
                    'label' => 'Paid',
                    'name' => 'payable_amount'
                ],
                [
                    'label' => 'COD',
                    'name' => 'surcharge'
                ],
                [
                    'label' => 'Charge',
                    'name' => 'delivery_charge'
                ],
                [
                    'label' => 'Action',
                    'name' => 'action'
                ],
            ]
        ];
    }
}
