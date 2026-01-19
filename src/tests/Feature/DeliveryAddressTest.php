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


class DeliveryAddressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }

    public function test_created_delivery_address_is_displayed_on_purchase_screen()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
        ]);

        $condition = Condition::where('name','良好')->first();

        $product = Product::factory()->create([
            'status' => 'selling',
        ]);

        $this->actingAs($user);


        $this->post(route('purchase.address.update',$product->id),[
            'postal_code' => '987-6543',
            'address' => '大阪市北区',
            'building' => '梅田ビル101',
        ]);

        $response = $this->get(route('purchase.show',$product->id));

        $response->assertStatus(200);

        $response->assertSee('987-6543');
        $response->assertSee('大阪市北区');
        $response->assertSee('梅田ビル101');

    }

    public function test_order_has_correct_delivery_address_after_purchase()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
        ]);

        $condition = Condition::where('name','良好')->first();

        $product = Product::factory()->create([
            'status' => 'selling',
        ]);

        $paymentMethod = PaymentMethod::where('code', 'convenience')->first();

        $this->actingAs($user)
        ->withSession([
            "payment_method_{$product->id}" => $paymentMethod->id,
            "postal_code_{$product->id}" => '987-6543',
            "address_{$product->id}" => '大阪市北区',
            "building_{$product->id}" => '梅田ビル101',
        ])
        ->post(route('purchase.store',['item_id' => $product->id]));


        $this->post(route('purchase.address.update',$product->id),[
            'postal_code' => '987-6543',
            'address' => '大阪市北区',
            'building' => '梅田ビル101',
        ]);

        $paymentMethod = PaymentMethod::where('code','convenience')->first();

        $this->patch(route('purchase.payment.update',$product->id),[
            'payment_method_id' => $paymentMethod->id,
        ]);

        $this->post(route('purchase.store',$product->id));

        $this->assertDatabaseHas('orders',[
            'product_id' => $product->id,
            'postal_code' => '987-6543',
            'address' => '大阪市北区',
            'building' => '梅田ビル101',
        ]);

    }

}
