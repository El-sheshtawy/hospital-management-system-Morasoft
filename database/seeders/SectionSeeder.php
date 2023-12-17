<?php

namespace Database\Seeders;

use App\Models\Section;
use Database\Factories\SectionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        SectionFactory::factoryForModel(Section::class)
            ->count(count(SectionFactory::$medicineDepartments))->create();
    }
}
