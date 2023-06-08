<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Parcel;
use App\Models\RiderParcel;
use Illuminate\Http\Request;
use App\Models\MerchantBalance;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParcelRequest;
use App\Http\Resources\ParcelResource;
use App\Http\Resources\ParcelCollection;
use App\Http\Resources\EntryParcelCollection;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role == 'admin'){
            $parcels = Parcel::filter($request)->with('merchant')->latest('id')->paginate($request->per_page ?? 10);
        } else {
            $parcels = Parcel::where('merchant_id', $user->id)->filter($request)->with('merchant')->latest('id')->paginate($request->per_page ?? 10);
        }

        return new ParcelCollection($parcels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParcelRequest $request)
    {
        if(auth()->user()->isAdmin()){
            $parcel = Parcel::create($request->validated() + [ 'status' => 'Processing' ]);
            $parcel->trackings()->create([
                'status' => 'Accepted'
            ]);
        }else{
            $parcel = Parcel::create($request->validated() + [ 'status' => 'On Review' ]);
        }

        if($parcel){
            return $this->successResponse("Parcel successfully created. Your Parcel ID #$parcel->id");
        }else{
            return $this->errorResponse('Parcel could not be created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Parcel $parcel)
    {
        $parcel->load('trackings', 'merchant', 'rider');
        return new ParcelResource($parcel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParcelRequest $request, Parcel $parcel)
    {
        $created = $parcel->update($request->validated());

        if($created){
            return $this->successResponse('Parcel successfully updated');
        }else{
            return $this->errorResponse('Parcel could not be updated');
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

    public function getMerchants(Request $request)
    {
        $merchants = User::role('merchant')->filter($request)->latest('id')->paginate($request->per_page ?? 10);
        return (new EntryParcelCollection($merchants));
    }

    public function getParcelsByMerchant(User $merchant, Request $request)
    {
        $parcels = $merchant->parcels()->filter($request)->latest('id')->paginate($request->per_page ?? 10);
        return new ParcelCollection($parcels);
    }

    public function calculateMerchantEarning($collection_amount, $delivery_charge)
    {
        $subtotal = ($collection_amount - $delivery_charge);
        // Substruct surcharge (cash risk fee) from subtotal
        return ($subtotal - (($subtotal * 1 ) / 100));

    }

    public function storeTracking(Parcel $parcel, Request $request)
    {
        $fields = $request->validate([
            'status' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255']
        ]);

        $rider_parcel = RiderParcel::find($parcel->rider_parcel_id);

        if($request->status == 'Delivered' && $parcel->status != 'Delivered'){
            $merchant_amount = $this->calculateMerchantEarning($parcel->collection_amount, $parcel->charge);

            MerchantBalance::create([
                'merchant_id' => $parcel->merchant_id,
                'debit' => 0,
                'credit' => $merchant_amount,
                'note' => 'parcel_delivery'
            ]);

            User::find($parcel->merchant_id)->increment('balance', $merchant_amount);

            $rider_parcel->total_delivered += 1;
            $rider_parcel->delivered_amount += $parcel->collection_amount;
        }

        if($request->status != 'Delivered' && $parcel->status == 'Delivered'){
            $merchant_amount = $this->calculateMerchantEarning($parcel->collection_amount, $parcel->charge);

            MerchantBalance::create([
                'merchant_id' => $parcel->merchant_id,
                'debit' => $merchant_amount,
                'credit' => 0,
                'note' => 'parcel_delivery',
            ]);

            User::find($parcel->merchant_id)->decrement('balance', $merchant_amount);

            $rider_parcel->total_delivered -= 1;
            $rider_parcel->delivered_amount -= $parcel->collection_amount;
        }

        if($request->status == 'Paid' && $parcel->status != 'Paid'){
            $merchant_amount = $this->calculateMerchantEarning($parcel->collection_amount, $parcel->charge);

            MerchantBalance::create([
                'merchant_id' => $parcel->merchant_id,
                'debit' => $merchant_amount,
                'credit' => 0,
                'note' => 'parcel_delivery'
            ]);

            User::find($parcel->merchant_id)->decrement('balance', $merchant_amount); 
        }

        if($request->status == 'Delivered' && $parcel->status == 'Paid'){
            $merchant_amount = $this->calculateMerchantEarning($parcel->collection_amount, $parcel->charge);

            MerchantBalance::create([
                'merchant_id' => $parcel->merchant_id,
                'debit' => 0,
                'credit' => $merchant_amount,
                'note' => 'parcel_delivery'
            ]);

            User::find($parcel->merchant_id)->increment('balance', $merchant_amount); 
        }

        if($request->status == 'Return' && $parcel->status != 'Return'){
            $rider_parcel->total_returned += 1;
            $rider_parcel->returned_amount += $parcel->collection_amount;
        }

        if($request->status != 'Return' && $parcel->status == 'Return'){
            $rider_parcel->total_returned -= 1;
            $rider_parcel->returned_amount -= $parcel->collection_amount;
        }

        if($request->status == 'Half Return' && $parcel->status != 'Half Return'){
            $rider_parcel->total_half_returned += 1;
            $rider_parcel->half_returned_amount += $parcel->collection_amount;
        }

        if($request->status != 'Half Return' && $parcel->status == 'Half Return'){
            $rider_parcel->total_half_returned -= 1;
            $rider_parcel->half_returned_amount -= $parcel->collection_amount;
        }

        if($request->status == 'Pending' && $parcel->status == 'Assigned'){
            $rider_parcel->total_parcel -= 1;
            $rider_parcel->collection_amount -= $parcel->collection_amount;

            $parcel->update(['rider_id' => NULL, 'rider_parcel_id' => NULL, 'status' => 'Pending']);
        }elseif($request->status == 'Accepted'){
            $parcel->update(['status' => "Processing"]);
        }else{
            $parcel->update(['status' => $request->status]);
        }

        $total_parcel = $rider_parcel->total_delivered + $rider_parcel->total_returned + $rider_parcel->total_half_returned;

        if($total_parcel == $rider_parcel->total_parcel){
            $rider_parcel->status = 'Completed';
        }

        $rider_parcel->save();

        $created = $parcel->trackings()->create($fields);

        if($created){
            return $this->successResponse('Tracking added successfully');
        }else{
            return $this->errorResponse('Tracking could not be added');
        }
    }
}
