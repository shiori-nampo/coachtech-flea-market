<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use App\Models\Condition;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\PaymentMethodSeeder;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }

    public function test_selected_payment_method_is_reflected_on_purchase_screen()
    {

        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
        ]);

        $condition = Condition::first();

        $product = Product::factory()->create([
            'status' => 'selling',
            'condition_id' => $condition->id,
        ]);

        $paymentMethod = PaymentMethod::where('name','コンビニ払い')->first();

        $this->actingAs($user);

        $this->patch(route('purchase.payment.update',[
            'item_id' => $product->id,
        ]),[
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response = $this->get(route('purchase.show',$product->id));

        $response->assertStatus(200);
        $response->assertSee($paymentMethod->name);
    }
}
