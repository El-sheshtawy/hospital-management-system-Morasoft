<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Allam',
            'email' => 'allam@gmail.com' ,
            'password' => Hash::make('password'),
            'phone_numbers' => ['first_number' => rand(3000100,4000000), 'second_number' => rand(1001000,2000000)],
            'remember_token' => Str::random(10),
        ]);

        Patient::create([
            'user_id' => $user->id,
            'birth_date' => now(),
            'gender' => 1,
            'blood_type' => 3,
            'address' => 'Tanta Alexandria'
        ]);
    }
}
