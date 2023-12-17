<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Admin::truncate();
        User::truncate();
        UserTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


       $adminUser = User::create([
           'name' => 'Normal Admin',
           'email' => 'admin@gmail.com' ,
           'password' => Hash::make('password'),
           'phone_numbers' => ['first_number' =>'01025263865', 'second_number' => '0403418263'],
           'remember_token' => Str::random(10),
       ])->assignRole('admin');

       Admin::create([
           'user_id' => $adminUser->id,
           'super_admin' => 0,
       ]);

        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'super_admin@gmail.com' ,
            'password' => Hash::make('password'),
            'phone_numbers' => ['first_number' =>'123456789', 'second_number' => '0123456789'],
            'remember_token' => Str::random(10),
        ])->assignRole('super_admin');

        Admin::create([
            'user_id' => $superAdminUser->id,
            'super_admin' => 1,
        ]);
    }
}
