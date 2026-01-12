<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\User;
use App\Models\Condition;

class ProductFactory extends Factory
{
    protected $models = Product::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),
            'name' => $this->faker->word(),
            'brand_name' => null,
            'description' => $this->faker->sentence(),
            'price' => 1000,
            'status' => 'sold',
            'image' => 'test.jpg',
        ];
    }
}
