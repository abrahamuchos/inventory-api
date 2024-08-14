<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'name' => $this->faker->name,
            'stock' => random_int(0, 100),
            'sku' => Item::generateSku(),
            'reorder_level' => random_int(15, 25),
        ];
    }
}
