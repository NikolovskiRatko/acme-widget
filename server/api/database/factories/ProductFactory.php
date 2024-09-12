<?php

namespace Database\Factories;

use App\Applications\Product\Model\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->word,
            'price' => $this->faker->randomFloat(2, 5, 100), // Random price between 5 and 100
        ];
    }
}
