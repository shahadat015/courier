<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParcelResource extends JsonResource
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
            'merchant_id' => $this->merchant_id,
            'merchant_name' => $this->merchant->business_name,
            'rider_name' => $this->rider->name ?? 'Not assigned',
            'rider_phone' => $this->rider->phone ?? 'Rider',
            'merchant_phone' => $this->merchant->phone,
            'invoice_no' => $this->invoice_no,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone, 
            'customer_address' => $this->customer_address,
            'collection_amount' => $this->collection_amount,
            'charge' => $this->charge,
            'charge_applied' => $this->charge_applied,
            'parcel_note' => $this->parcel_note,
            'status' => $this->status,
            'entry_date' => $this->created_at,
            'updated_date' => $this->updated_at,
            'trackings' => TrackingResource::collection($this->trackings)
        ];
    }
}
