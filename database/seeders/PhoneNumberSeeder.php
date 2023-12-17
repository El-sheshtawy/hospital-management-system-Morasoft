<?php

namespace Database\Seeders;

use App\Models\PhoneNumber;
use Database\Factories\PhoneNumberFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneNumberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('phone_numbers')->truncate();
        PhoneNumberFactory::factoryForModel(PhoneNumber::class)->count(5)->create();

        PhoneNumber::create([
            'phoneable_type' => 'App\Models\Admin',
            'phoneable_id' => 1,
            'numbers' => ['01025263865', '0403418263']
        ]);
    }
}
