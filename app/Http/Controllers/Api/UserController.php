<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $user['image'] = $user->image ? asset("storage/$user->image") : null;
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => ['nullable', 'mimes:jpg,png,jpeg,bmp', 'max:2000'],
        ]);

        if($request->hasFile('image')){
            $this->removeImage($user->image);
            $fields['image'] = $request->image->store('user');
        }

        $updated = $user->update($fields);

        if($updated) {
            return $this->successResponse('Profile successfully updated');
        }else{
            return $this->errorResponse('Profile could not be updated');
        }
    }
}