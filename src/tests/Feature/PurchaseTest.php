<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\Condition;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\PaymentMethodSeeder;


class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        parent::setUp();
        $this->seed(PaymentMethodSeeder::class);
    }

    public function test_user_can_purchase_a_product()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
        ]);

        $condition = Condition::where('name','良好')->first();
        $product = Product::factory()->create([
            'status' => 'selling',
            'condition_id' => $condition->id,
        ]);

        $paymentMethod = PaymentMethod::where('name','コンビニ払い')->first();

        $this->actingAs($user)
            ->withSession([
                "payment_method_{$product->id}" => $paymentMethod->id,
                "postal_code_{$product->id}" => $user->postal_code,
                "address_{$product->id}" => $user->address,
        ]);

        $response = $this->post(route('purchase.store',[ 'item_id' => $product->id,
        ]));

        $response->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('orders',[
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method_id' => $paymentMethod->id,
        ]);
    }


    public function test_purchased_product_is_marked_as_sold()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
        ]);

        $condition = Condition::where('name','良好')->first();

        $product = Product::factory()->create([
            'status' => 'selling',
            'condition_id' => $condition->id,
        ]);

        $paymentMethod = PaymentMethod::where('name','コンビニ払い')->first();

        $this->actingAs($user)
            ->withSession([
                "payment_method_{$product->id}" => $paymentMethod->id,
            ]);

        $response = $this->post(route('purchase.store',[
            'item_id' => $product->id,
        ]));

        $response->assertRedirect(route('items.index'));

        $indexResponse = $this->get(route('items.index'));

        $indexResponse->assertSee('sold');

    }


    public function test_purchased_product_is_shown_in_user_profile()
    {
        $condition = Condition::where('name','良好')->first();

        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
        ]);

        $product = Product::factory()->create([
            'status' => 'selling',
            'condition_id' => $condition->id,
        ]);

        $paymentMethod = PaymentMethod::where('name','コンビニ払い')->first();

        $this->actingAs($user)
            ->withSession([
                "payment_method_{$product->id}" => $paymentMethod->id,
            ]);

        $this->post(route('purchase.store',[
            'item_id' => $product->id,
        ]));

        $this->assertDatabaseHas('orders',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get(route('mypage',['page' => 'buy']));

        $response->assertStatus(200);
        $response->assertSee($product->name);

    }

}
