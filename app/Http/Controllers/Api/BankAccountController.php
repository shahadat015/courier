<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $merchant, Request $request)
    {
        $fields = $request->validate([
            'bank_name' => ['nullable', 'required_if:bank_type,bank_account', 'string', 'max:255'],
            'branch' => ['nullable', 'required_if:bank_type,bank_account', 'string', 'max:255'],
            'account_name' => ['nullable', 'required_if:bank_type,bank_account', 'string', 'max:255'],
            'account_number' => ['nullable', 'required_if:bank_type,bank_account', 'integer'],
            'bank_type' => ['required', 'string', 'max:255'],
            'provider' => ['nullable', 'required_if:bank_type,mobile_banking', 'string', 'max:255'],
            'account_type' => ['nullable', 'required_if:bank_type,mobile_banking', 'string', 'max:255'],
            'phone_number' => ['nullable', 'required_if:bank_type,mobile_banking', 'string', 'max:30'],
        ],[
            'bank_name.required_if' => 'The bank name is required' ,
            'branch.required_if' => 'The branch name is required' ,
            'account_name.required_if' => 'The account name is required' ,
            'account_number.required_if' => 'The account number is required'  ,
            'account_type.required_if' => 'The account trype is required' ,
            'phone_number.required_if' => 'The phone number is required' ,
        ]);

        $created = $merchant->accounts()->create($fields);

        if($created){
            return $this->successResponse('Bank account added successfully');
        }else{
            return $this->errorResponse('Bank account cound not be added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
