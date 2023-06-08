<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrowRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->account->bank_type == 'bank_account'){
            $account = $this->account->bank_name . ", " . $this->account->branch . ", " . $this->account->account_name . ", " . $this->account->account_number;
        }else{
            $account = $this->account->provider . ": " . $this->account->phone_number . " (" . $this->account->account_type . ")";
        }

        return [
            'merchant_name' => $this->merchant->business_name,
            'contact' => $this->merchant->phone,
            'created_at' =>  $this->created_at,
            'updated_at' =>  $this->updated_at,
            'status' =>  $this->status,
            'bank_account_id' =>  $this->bank_account_id,
            'bank_accounts' => $this->merchant->accounts,
            'account_info' => $account,
        ];
    }
}
