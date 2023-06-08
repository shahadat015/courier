<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected $guarded = [];

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function scopeFilter($query, $request)
    {
        $search = $request->input('query');
        
        $query->when($search, function($q) use ($search) {
            $q->where('id', $search);
        });

        return $query;
    }
}
