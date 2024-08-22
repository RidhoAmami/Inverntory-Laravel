<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'harga' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
