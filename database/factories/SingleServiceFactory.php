<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

class SingleServiceFactory extends Factory
{
    public static array $singleServicesNames = [
        'تبييض اسنان', 'تنظيف الجير', 'حشو عصب', 'تركيب تقويم', 'خلع ضرس',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomElement([1000, 500, 600 , 400, 300, 200]),
            'active' => 1,
            'name' => $this->faker->unique()->randomElement(self::$singleServicesNames),
            'description' => $this->faker->paragraph,
            'created_at' => $this->faker->date(),
            'updated_at' => null,
        ];
    }
}
