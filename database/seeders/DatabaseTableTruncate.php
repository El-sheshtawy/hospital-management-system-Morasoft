<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseTableTruncate extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ambulance_translations')->truncate();
        DB::table('ambulances')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
