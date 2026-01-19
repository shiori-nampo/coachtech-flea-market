<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Condition;
use App\Models\PaymentMethod;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\PaymentMethodSeeder;



class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }


    public function test_profile_page_is_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('mypage'));

        $response->assertStatus(200);

    }

    public function test_user_name_and_profile_image_are_displayed()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile/test.png',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('mypage'));

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');

        $response->assertSee('storage/profile/test.png');

    }

    public function test_selling_products_are_displayed()
    {

        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品テスト商品',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('mypage',['page' => 'sell']));

        $response->assertStatus(200);

        $response->assertSee('出品テスト商品');
    }

    public function test_purchased_products_are_displayed()
    {

        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $paymentMethod = PaymentMethod::first();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入テスト商品',
        ]);

        Order::factory()->create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'payment_method_id' => $paymentMethod->id,
        ]);

        $this->actingAs($buyer);

        $response = $this->get(route('mypage', ['page' => 'buy']));

        $response->assertStatus(200);

        $response->assertSee('購入テスト商品');

    }

    public function test_profile_edit_form_has_initial_values()
    {
        $condition = Condition::where('name','良好')->first();

        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都板橋区',
            'profile_image' => 'profile/test.png',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('profile.edit'));

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都板橋区');

        $response->assertSee('storage/profile/test.png');
    }
}
