<?php

namespace Database\Seeders;

use App\Models\SingleService;
use Database\Factories\SingleServiceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SingleServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('single_service_translations')->truncate();
        DB::table('single_services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        SingleServiceFactory::factoryForModel(SingleService::class)
            ->count(count(SingleServiceFactory::$singleServicesNames))->create();
    }
}
