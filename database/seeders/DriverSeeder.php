<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $ids =  Driver::all()->pluck('user_id')->toArray();
        User::whereIn('id', $ids)->delete();

        $count = [1, 2, 3, 4, 5];

        foreach ($count as $number) {
           $user =  User::create([
                'name' => 'Driver '.$number,
                'email' => "driver{$number}@gmail.com" ,
                'password' => Hash::make('password'),
                'phone_numbers' => ['first_number' =>'5256954415', 'second_number' => '01676723456789'],
                'remember_token' => Str::random(10),
            ]);

            Driver::create([
                'user_id' => $user->id,
                'license_number' => '11111111'.$number,
            ]);
        }
    }
}
