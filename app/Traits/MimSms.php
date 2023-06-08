<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait MimSms {

    public function sendSms($messages)
    {
        $data = [
            "api_key" => config('mimsms.api_key'),
            "senderid" => config('mimsms.sender_id'),
            "messages" => json_encode($messages)
        ];

        $response = Http::post("https://esms.mimsms.com/smsapimany", $data);

        if($response->successful() && $response->status() == 200){
            return true;
        }else{
            return false;
        }
    }

}