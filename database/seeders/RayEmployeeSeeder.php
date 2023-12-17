<?php

namespace Database\Seeders;

use App\Models\RayEmployee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RayEmployeeSeeder extends Seeder
{
    public function run(): void
    {
      $ids =  RayEmployee::all()->pluck('user_id')->toArray();
        User::whereIn('id', $ids)->delete();

        $user = User::create([
            'name' => 'Rays Employee',
            'email' => 'rays_employee@gmail.com' ,
            'password' => Hash::make('password'),
            'phone_numbers' => ['first_number' =>'333333333', 'second_number' => '333333333'],
            'remember_token' => Str::random(10),
        ])->assignRole('rays_employee');

        RayEmployee::create([
            'user_id' => $user->id,
        ]);
    }
}
