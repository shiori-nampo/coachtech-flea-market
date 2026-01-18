<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'payment_method_id' => 1,
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
            'building' => 'テストビル',
        ];
    }
}
