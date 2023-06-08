<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Parcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            [    'title' => "Today's Parcel",
                'icon' => 'parcel',
                'count' => Parcel::whereDate('created_at', today())->count(),
                'role' => 'admin'
            ],
            [
                'title' => "Total Parcel",
                'icon' => 'parcel',
                'count' => Parcel::count(),
                'role' => 'admin'
            ],
            [
                'title' => "Total Merchant",
                'icon' => 'merchant',
                'count' => User::role('merchant')->count(),
                'role' => 'admin'
            ],
            [
                'title' => "Total Rider",
                'icon' => 'rider',
                'count' => User::role('rider')->count(),
                'role' => 'admin'
            ]
        ];
    }
}