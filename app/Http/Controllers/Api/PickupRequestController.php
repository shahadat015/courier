<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PickupRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PickupRequestResource;
use App\Http\Resources\PickupRequestCollection;

class PickupRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pickups = PickupRequest::filter($request)->latest('id')->paginate($request->per_page ?? 10);
        return new PickupRequestCollection($pickups);
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
            'shop_id' => ['required', 'integer'],
            'total_parcel' => ['required', 'integer'],
            'note' => ['nullable', 'string', 'max:30'],
        ], [
            'shop_id.required' => 'The Pickup location is required'
        ]);

        $created = PickupRequest::create($fields + ['merchant_id' => auth()->id()]);

        if($created){
            return $this->successResponse('Pickup Request sent successfully');
        }else{
            return $this->errorResponse('Pickup Request cound not be sent');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PickupRequest $pickupRequest)
    {
        return new PickupRequestResource($pickupRequest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PickupRequest $pickupRequest)
    {
        $fields = $request->validate([
            'shop_id' => ['required', 'integer'],
            'total_parcel' => ['required', 'integer'],
            'note' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'string', 'max:30'],
        ], [
            'shop_id.required' => 'The Pickup location is required'
        ]);

        $updated = $pickupRequest->update($fields);

        if($updated){
            return $this->successResponse('Pickup Request updated successfully');
        }else{
            return $this->errorResponse('Pickup Request cound not be updated');
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
