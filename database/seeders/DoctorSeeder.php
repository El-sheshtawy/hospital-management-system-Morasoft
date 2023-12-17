<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Doctor::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $doctorsIds = array(3, 4, 5, 6, 7);

        foreach ($doctorsIds as $doctorsId) {
            User::create([
                'id' => $doctorsId,
                'name' => $this->random_strings(10),
                'email' => $this->random_strings(7).'@gmail.com' ,
                'password' => Hash::make('password'),
                'phone_numbers' => ['first_number' => rand(3000000,4000000), 'second_number' => rand(1000000,2000000)],
                'remember_token' => Str::random(10),
            ])->assignRole('doctor');
        }

      $usersIds = User::all()->whereNotIn('id',[1,2])->pluck('id')->toArray();

        foreach ($usersIds as $id) {
            Doctor::create([
                'user_id' => $id,
                'section_id' => Section::all()->random()->id,
            ]);
        }

        // DoctorFactory::factoryForModel(Doctor::class)->count(5)->create();
        $doctors = Doctor::all();
        // Add records in appointment_doctor table (Many to Many) relationship
        $appointments = Appointment::all();
        $doctors->each(function ($doctor) use ($appointments) {
            $doctor->appointments()->attach($appointments->random(rand(1,7))->pluck('id')->toArray());
        });
    }

    function random_strings($length_of_string)
    {

        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),
            0, $length_of_string);
    }
}
