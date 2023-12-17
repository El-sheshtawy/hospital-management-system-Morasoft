<?php

namespace Database\Seeders;

use App\Models\BookingOfficer;
use App\Models\Doctor;
use App\Models\User;
use App\Models\UserTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BookingOfficerSeeder extends Seeder
{
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BookingOfficer::truncate();
        UserTranslation::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::create([
            'name' => 'Allam_Booking',
            'email' => 'allam_book@gmail.com' ,
            'password' => Hash::make('password'),
            'phone_numbers' => ['first_number' => rand(300200,4000000), 'second_number' => rand(1001000,2000000)],
            'remember_token' => Str::random(10),
        ]);

        BookingOfficer::create([
            'user_id' => $user->id,
        ]);
    }
}
