<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
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
            'pickup_location' => $this->pickup_location,
            'business_name' => $this->business_name,
            'shops' => $this->shops,
            'bank_accounts' => $this->accounts,
            'status' => $this->status,
            'performance' => [
                'performance' => 0,
                'cancel_rate' => 0,
                'delivery_rate' => 0,
                'parcel_delivered' => $this->merchantParcelDelivered(),
            ],
            'cards' => [
                [
                    'title' => "Today's Earning",
                    'icon' => 'payment',
                    'count' => $this->todaysEarning(),
                    'role' => 'merchant'

                ],
                [
                    'title' => "Balance",
                    'icon' => 'payment',
                    'count' => $this->balance,
                    'role' => 'merchant'
                ]
            ]
        ];
    }
}
