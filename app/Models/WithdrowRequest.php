<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class WithdrowRequest extends Model
{
    protected $guarded = [];

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function account()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function scopeFilter($query, $request)
    {
        $search = $request->input('query');
        
        $query->when($search, function($q) use ($search) {
            $q->where('id', $search);
        });

        return $query;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M dS Y, h:i:s a');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M dS Y, h:i:s a');
    }
}
