<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BookingOfficerSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            SectionSeeder::class,
            AppointmentSeeder::class,
            DoctorSeeder::class,
            ImageSeeder::class,
            RayEmployeeSeeder::class,
            DriverSeeder::class,
           SingleServiceSeeder::class,
            PatientSeeder::class,
        ]);


        //  Admin::factory(5)->create();
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
