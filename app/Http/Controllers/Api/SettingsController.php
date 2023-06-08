<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::first();
        $settings['website'] = config('app.url');
        $settings['logo'] = asset("storage/$settings->logo");
        return response()->json($settings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fields = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'mimes:jpg,png,jpeg,bmp', 'max:2000'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $settings = Setting::first();

        if($request->hasFile('logo')){
            $this->removeImage($settings->logo);
            $fields['logo'] = $request->logo->store('logo');
        }

        $updated = $settings->update($fields);

        if($updated) {
            return $this->successResponse('Settings successfully updated');
        }else{
            return $this->successResponse('Settings could not be updated');
        }
        
    }
}
