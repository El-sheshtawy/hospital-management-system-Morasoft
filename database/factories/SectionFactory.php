<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public static array $medicineDepartments =  ['قسم المخ والاعصاب','قسم الجراحة','قسم الاطفال',
        'قسم النساء والتوليد','قسم العيون','قسم الباطنة'];

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(self::$medicineDepartments),
            'description' =>$this->faker->paragraph,
            'updated_at' => null,
        ];
    }
}
