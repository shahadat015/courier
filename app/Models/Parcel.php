<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $guarded = [];

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

    public function trackings()
    {
        return $this->hasMany(ParcelTracking::class);
    }

    public function scopeFilter($query, $request)
    {
        $search = $request->input('query');
        
        $query->when($search, function($q) use ($search) {
            $q->where('id', $search)
                ->orWhere('status', $search)
                ->orWhere('invoice_no', $search)
                ->orWhere('customer_phone', $search);
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
