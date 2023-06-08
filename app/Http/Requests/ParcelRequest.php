<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ParcelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_address' => ['required', 'string', 'max:255'],
            'invoice_no' => ['nullable', 'string', 'max:255'],
            'collection_amount' => ['nullable', 'numeric'],
            'charge' => ['nullable', 'numeric'],
            'parcel_note' => ['nullable', 'string'],
            'merchant_id' => ['required', 'integer'],
        ];
    }
}
