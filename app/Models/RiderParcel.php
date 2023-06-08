<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RiderParcel extends Model
{
    protected $guarded = [];

    public function scopeFilter($query, $request)
    {
        $search = $request->input('query');
        
        $query->when($search, function($q) use ($search) {
            $q->where('id', $search)
                ->orWhere('status', $search);
        });

        return $query;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-M-Y');
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
