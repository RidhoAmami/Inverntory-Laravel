<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'aksi' => $this->faker->randomElement(['masuk', 'keluar']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'tanggal' => $this->faker->date,
        ];
    }
}
