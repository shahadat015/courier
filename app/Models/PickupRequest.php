<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    protected $guarded = [];

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
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
