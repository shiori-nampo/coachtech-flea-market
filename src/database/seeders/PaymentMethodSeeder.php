<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['name'=> 'コンビニ払い','code' => 'convenience'],
            ['name' => 'カード支払い','code' => 'card'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
