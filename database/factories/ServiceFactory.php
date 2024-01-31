<?php

namespace Database\Factories;

use App\Enums\ServiceTypeEnum;
use App\Enums\UnitTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ServiceTypeEnum::getRandomValue(),
            'unit' => UnitTypeEnum::getRandomValue(),
            'cost' => (float) (fake()->numberBetween(1, 99) . '.1'),
        ];
    }
}
