<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // Admin Permissions

        $adminPermissions = [

            ['name' => 'show-sections'],
            ['name' => 'create-section'],
            ['name' => 'edit-section'],
            ['name' => 'show-section'],
            ['name' => 'delete-section'],

            ['name' => 'show-doctors'],
            ['name' => 'create-doctor'],
            ['name' => 'edit-doctor'],
            ['name' => 'show-doctor'],
            ['name' => 'delete-doctor'],

            ['name' => 'show-single-services'],
            ['name' => 'create-single-service'],
            ['name' => 'edit-single-service'],
            ['name' => 'show-single-service'],
            ['name' => 'delete-single-service'],

            ['name' => 'show-groups-services'],
            ['name' => 'create-group-services'],
            ['name' => 'edit-group-services'],
            ['name' => 'show-group-services'],
            ['name' => 'delete-group-services'],

            ['name' => 'show-insurances'],
            ['name' => 'create-insurance'],
            ['name' => 'edit-insurance'],
            ['name' => 'show-insurance'],
            ['name' => 'delete-insurance'],


            ['name' => 'show-ambulances'],
            ['name' => 'create-ambulance'],
            ['name' => 'edit-ambulance'],
            ['name' => 'show-ambulance'],
            ['name' => 'delete-ambulance'],

            ['name' => 'show-patients'],
            ['name' => 'create-patient'],
            ['name' => 'edit-patient'],
            ['name' => 'show-patient'],
            ['name' => 'delete-patient'],

            ['name' => 'show-receipts'],
            ['name' => 'create-receipt'],
            ['name' => 'edit-receipt'],
            ['name' => 'show-receipt'],
            ['name' => 'delete-receipt'],

            ['name' => 'show-payments'],
            ['name' => 'create-payment'],
            ['name' => 'edit-payment'],
            ['name' => 'show-payment'],
            ['name' => 'delete-payment'],

            ['name' => 'show-rays-employees'],
            ['name' => 'create-rays-employee'],
            ['name' => 'edit-rays-employee'],
            ['name' => 'show-rays-employee'],
            ['name' => 'delete-rays-employee'],

            //Multi Permissions related doctors and rays_employees
            ['name' => 'show-laboratories'],
            ['name' => 'edit-laboratory'],
            ['name' => 'delete-laboratory'],

            ['name' => 'show-rays'],  //  'show-rays|show-doctor-rays|show-rays-employee-rays'
            ['name' => 'edit-rays'],
            ['name' => 'delete-rays'],

            ['name' => 'create-invoices'],
            ['name' => 'edit-invoices'],
            ['name' => 'show-invoices'],
            ['name' => 'delete-invoices'],

            ['name' => 'edit-diagnosis'],
            ['name' => 'show-diagnosis'],
            ['name' => 'delete-diagnosis'],

            ];

        foreach ($adminPermissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
            ])->assignRole('admin');
        }


        // Doctor Permissions

        $doctorPermissions = [
            ['name' => 'show-related-diagnosis'],
            ['name' => 'create-diagnosis'],


            ['name' => 'show-doctor-related-invoices'],

            ['name' => 'show-doctor-related-laboratory'],
            ['name' => 'create-doctor-laboratory'],

            ['name' => 'show-related-patients-details'],

            ['name' => 'create-doctor-rays'],
            ['name' => 'show-doctor-rays'],
            ['name' => 'show-doctor-laboratory'],
        ];

        foreach ($doctorPermissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
            ])->syncRoles(['admin','doctor']);
        }

        // Rays Employee Permissions

        $raysEmployeePermissions = [

            ['name' => 'show-rays-employee-related-invoices'],
            ['name' => 'update-rays-employee-rays'],
            ['name' => 'show-rays-employee-laboratory'],
            ['name' => 'show-rays-employee-rays'],
        ];

        foreach ($raysEmployeePermissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
            ])->syncRoles(['admin','rays_employee']);
        }
    }
}
