<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Parcel;
use App\Models\RiderParcel;
use Illuminate\Http\Request;
use App\Events\ParcelAssigned;
use App\Models\ParcelTracking;
use App\Models\MerchantBalance;
use Illuminate\Validation\Rule;
use App\Http\Requests\RiderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RiderResource;
use App\Http\Resources\RiderCollection;
use App\Http\Resources\RiderParcelResource;
use App\Http\Resources\RiderParcelCollection;
use App\Http\Resources\AssignParcelCollection;

class RiderController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $riders = User::role('rider')->filter($request)->latest('id')->paginate($request->per_page ?? 10);
        return new RiderCollection($riders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RiderRequest $request)
    {
               
        $created = User::create($request->validated());

        if($created){
            return $this->successResponse('Rider registration successfull');
        }else{
            return $this->errorResponse('Rider registration failed');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $rider)
    {
        $rider->load('riderParcels');
        return new RiderResource($rider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $rider)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', Rule::unique('users')->ignore($rider->id)],
            'present_address' => ['required', 'string', 'max:255'],
            'permanent_address' => ['required', 'string', 'max:255'],
        ]);

        $updated = $rider->update($fields);

        if($updated) {
            return $this->successResponse('Rider successfully updated');
        }else{
            return $this->successResponse('Rider could not be updated');
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

    public function assignParcels(User $rider, Request $request)
    {
        
        $riderParcel = RiderParcel::create([
            'collection_amount' =>$request->collection_amount,
            'total_parcel' => $request->total_parcel,
            'rider_id' => $rider->id
        ]);
        
        if(true){
            $parcel_ids = [];
            $trackings = [];
            $messages = [];
            $app_name = config('app.name');

            foreach($request->parcels as $parcel){
                $trackings[] = [
                    'parcel_id' => $parcel['id'],
                    'status' => 'Assigned',
                    'description' => "Assigned to $rider->name ($rider->phone)"
                ];

                $parcel_ids[] = $parcel['id'];

                $parcel_id = $parcel['id'];
                $customer_name = $parcel['name'];
                $merchant_name = $parcel['merchant'];
                
                $messages[] = [
                    "to" => $parcel['phone'],
                    "message" => "Dear $customer_name, Your parcel ID# $parcel_id from $merchant_name is on the way to be delivered. Agent: $rider->name($rider->phone). $app_name"
                ];
            }

            Parcel::whereIn('id', $parcel_ids)->update([
                'status' => 'Assigned', 
                'rider_id' => $rider->id, 
                'rider_parcel_id' => $riderParcel->id
            ]);

            ParcelTracking::insert($trackings);

            ParcelAssigned::dispatch($messages);

            return $this->successResponse('Parcels assigned successfully', $riderParcel->id);
        }else{
            return $this->errorResponse('Parcels could not be assigned');
        }
    }

    public function getParcels(Request $request)
    {
        $parcels = Parcel::where('status', 'Processing')->filter($request)->with('merchant')->latest('id')->paginate($request->per_page ?? 10);
        return new AssignParcelCollection($parcels);
    }

    public function getParcelsByRider(User $rider, Request $request)
    {
        $parcels = $rider->consignments()->filter($request)->latest('id')->paginate($request->per_page ?? 10);
        return new RiderParcelCollection($parcels);
    }

    public function getRiderParcel(RiderParcel $riderParcel)
    {
        return new RiderParcelResource($riderParcel);
    }

    public function calculateMerchantEarning($collection_amount, $delivery_charge)
    {
        $subtotal = ($collection_amount - $delivery_charge);
        // Substruct surcharge (cash risk fee) from subtotal
        return ($subtotal - (($subtotal * 1 ) / 100));

    }

    public function updateRiderParcel(RiderParcel $riderParcel, Request $request)
    {     
        $parcels = [];
        $balances = [];

        if($request->delivered){          
            $ids = [];
            
            foreach($request->delivered as $parcel){                   
                $ids[] = $parcel['id'];

                $parcels[] = [
                    'parcel_id' => $parcel['id'],
                    'status' => 'Delivered',
                ];

                $merchant_amount = $this->calculateMerchantEarning($parcel['collection_amount'], $parcel['charge']);

                MerchantBalance::create([
                    'merchant_id' => $parcel['merchant_id'],
                    'debit' => 0,
                    'credit' => $merchant_amount,
                    'note' => 'parcel_delivery'
                ]);

                User::find($parcel['merchant_id'])->increment('balance', $merchant_amount);
            }

            Parcel::whereIn('id', $ids)->update(['status' => 'Delivered']);

            $riderParcel->total_delivered += $request->total_delivered;
            $riderParcel->delivered_amount += $request->delivered_amount;
        }else{
            $riderParcel->total_delivered = 0;
            $riderParcel->delivered_amount = 0;
        }


        if($request->returned){
            $ids = [];

            foreach($request->returned as $parcel){
                $ids[] = $parcel['id'];

                $parcels[] = [
                    'parcel_id' => $parcel['id'],
                    'status' => 'Return',
                ];
            }

            Parcel::whereIn('id', $ids)->update(['status' => 'Return']);

            $riderParcel->total_returned += $request->total_half_returned;
            $riderParcel->returned_amount += $request->half_returned_amount;
        }else{
            $riderParcel->total_returned = 0;
            $riderParcel->returned_amount = 0;
        }

        if($request->half_returned){
            $ids = [];

            foreach($request->half_returned as $parcel){
                $ids[] = $parcel['id'];

                $parcels[] = [
                    'parcel_id' => $parcel['id'],
                    'status' => 'Half Return',
                ];
            }

            Parcel::whereIn('id', $ids)->update(['status' => 'Half Return']);

            $riderParcel->total_half_returned += $request->total_half_returned;
            $riderParcel->half_returned_amount += $request->half_returned_amount;
        }else{
            $riderParcel->total_half_returned = 0;
            $riderParcel->half_returned_amount = 0;
        }

        if($request->pending){
            $ids = [];
            
            foreach($request->pending as $parcel){
                $ids[] = $parcel['id'];
                
                $parcels[] = [
                    'parcel_id' => $parcel['id'],
                    'status' => 'Pending',
                ];
            }

            Parcel::whereIn('id', $ids)->update(['status' => 'Processing', 'rider_id' => NULL, 'rider_parcel_id' => Null]);

            $riderParcel->total_parcel -= $request->total_pending;
            $riderParcel->collection_amount -= $request->pending_amount;
        }
        
        ParcelTracking::insert($parcels);

        $riderParcel->status = $request->status; 
        $updated = $riderParcel->save();

        if($updated){
            return $this->successResponse('Rider Parcel updated successfully');
        }else{
            return $this->errorResponse('Rider Parcel could not be updated');
        }
    }
}
