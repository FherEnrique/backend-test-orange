<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'SKU' => $this->faker->uuid(), 
            'name' => $this->faker->word(), 
            'stock' => $this->faker->numberBetween(1, 20), 
            'price' => $this->faker->numberBetween(1, 20), 
            'description' => $this->faker->text(),
        ];
    }
}
