<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'phone',
        'password',
        'reference',
        'business_name',
        'pickup_location',
        'present_address',
        'permanent_address',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'merchant_id');
    }

    public function riderParcels()
    {
        return $this->hasMany(Parcel::class, 'rider_id');
    }

    public function consignments()
    {
        return $this->hasMany(RiderParcel::class, 'rider_id');
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'merchant_id');
    }

    public function accounts()
    {
        return $this->hasMany(BankAccount::class, 'merchant_id');
    }

    public function pickups()
    {
        return $this->hasMany(PickupRequest::class, 'merchant_id');
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeFilter($query, $request)
    {
        $search = $request->input('query');
        
        $query->when($search, function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
            ->orWhere('business_name', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
        });

        return $query;
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function riderParcelDelivered()
    {
        return $this->riderParcels()->where('status', 'Delivered')->count();
    }

    public function merchantParcelDelivered()
    {
        return $this->parcels()->where('status', 'Delivered')->count();
    }

    public function earnings()
    {
        return $this->hasMany(MerchantBalance::class, 'merchant_id');
    }

    public function todaysEarning()
    {
        return round($this->earnings()->whereDate('created_at', today())->sum('credit'), 2);
    }
}
