<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WithdrowRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\WithdrowRequestResource;
use App\Http\Resources\WithdrowRequestCollection;

class WithdrowRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $withdows = WithdrowRequest::filter($request)->latest('id')->paginate($request->per_page ?? 10);
        return new WithdrowRequestCollection($withdows);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'bank_account_id' => ['required', 'integer'],
        ], [
            'bank_account_id.required' => 'The withdrow method is required'
        ]);

        $created = WithdrowRequest::create($fields + ['merchant_id' => auth()->id()]);

        if($created){
            return $this->successResponse('Payment Request sent successfully');
        }else{
            return $this->errorResponse('Payment Request cound not be sent');
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrowRequest $withdrowRequest)
    {
        return new WithdrowRequestResource($withdrowRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrowRequest $withdrowRequest)
    {
        $fields = $request->validate([
            'bank_account_id' => ['required', 'integer'],
            'status' => ['required', 'string'],
        ], [
            'shop_id.required' => 'The Pickup location is required'
        ]);

        $updated = $withdrowRequest->update($fields);

        if($updated){
            return $this->successResponse('Withdrow Request updated successfully');
        }else{
            return $this->errorResponse('Withdrow Request cound not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
