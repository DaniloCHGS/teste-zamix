<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['simple', 'composite']);
        return [
            'name' => $this->faker->word(),
            'type' => $type,
            'cost_price' => $type === 'simple' ? $this->faker->randomFloat(2, 10, 100) : null,
            'sale_price' => $this->faker->randomFloat(2, 20, 200),
        ];
    }
}
