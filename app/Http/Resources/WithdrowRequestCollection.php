<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WithdrowRequestCollection extends ResourceCollection
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
            "data" => $this->collection->transform(function($withdrow){

                if($withdrow->account->bank_type == 'bank_account'){
                    $account = $withdrow->account->bank_name . "<br>" . $withdrow->account->branch . "<br>" . $withdrow->account->account_name . "<br>" . $withdrow->account->account_number;
                }else{
                    $account = $withdrow->account->provider . ": " . $withdrow->account->phone_number . " (" . $withdrow->account->account_type . ")";
                }

                return [
                    'id' => $withdrow->id,
                    'merchant' => $withdrow->merchant->business_name . "<br>" . $withdrow->merchant->phone,
                    'account' => $account,
                    'status' => $withdrow->status,
                    'action' => ['edit'],
                ];
            }),
            "columns" => [
                [
                    'label' => 'ID',
                    'name' => 'id'
                ],
                [
                    'label' => 'Merchant Details',
                    'name' => 'merchant'
                ],
                [
                    'label' => 'Account Details',
                    'name' => 'account'
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
