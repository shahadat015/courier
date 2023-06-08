<?php

namespace App\Http\Resources;

use App\Http\Resources\RiderResource;
use App\Http\Resources\ParcelCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'payment' => [
                'id' => $this->id,
                'collection_amount' => $this->collection_amount,
                'total_delivery_charge' => $this->total_delivery_charge,
                'subtotal' => $this->subtotal,
                'surcharge' => $this->surcharge,
                'total_payable' => $this->total_payable,
                'date' => $this->created_at,
                'total_parcel' => $this->total_parcel,
            ],
            'merchant' => new MerchantResource($this->merchant),
            'parcels' => ParcelResource::collection($this->parcels),
        ];
    }
}
