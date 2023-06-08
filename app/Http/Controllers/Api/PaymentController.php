<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Parcel;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\MerchantBalance;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParcelResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $merchant,Request $request)
    {
        $payments = Payment::where('merchant_id', $merchant->id)->filter($request)->with('merchant')->latest('id')->paginate($request->per_page ?? 10);
        return new PaymentCollection($payments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = Payment::create($request->only('merchant_id', 'collection_amount', 'total_delivery_charge', 'subtotal', 'surcharge', 'total_payable', 'total_parcel'));

        if($payment){
            Parcel::whereIn('id', $request->parcels)->update(['status' => 'Paid', 'payment_id' => $payment->id]);   

            MerchantBalance::create([
                'merchant_id' => $request->merchant_id,
                'debit' => $request->total_payable,
                'credit' => 0,
                'note' => 'parcel_delivery'
            ]);

            User::find($request->merchant_id)->decrement('balance', $request->total_payable); 
            return $this->successResponse('Payment created successfully');
        }else{
            return $this->errorResponse('Payment could not be created');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function geParcels(User $merchant)
    {
        $parcels = $merchant->parcels()->whereIn('status', ['Delivered', 'Return', 'Half Return'])->get();

        return ParcelResource::collection($parcels);
    }
}
