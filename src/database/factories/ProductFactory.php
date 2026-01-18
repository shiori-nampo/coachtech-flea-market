<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\User;
use App\Models\Condition;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::inRandomOrder()->value('id'),
            'name' => $this->faker->word(),
            'brand_name' => null,
            'description' => $this->faker->sentence(),
            'price' => 1000,
            'status' => 'selling',
            'image' => 'test.jpg',
        ];
    }
}
