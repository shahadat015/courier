<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '01830964337',
                'role' => 'admin',
                'business_name' => "",
                'pickup_location' => "",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Merchant',
                'email' => 'merchant@gmail.com',
                'phone' => '01928312500',
                'role' => 'merchant',
                'business_name' => "Merchant's Shop",
                'pickup_location' => "East Kazipara, Mirpur, Dhaka",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]
        ]);
    }
}
