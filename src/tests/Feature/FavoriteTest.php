<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Favorite;


class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_page_can_be_displayed()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('items.detail',['product' => $product->id]));

        $response->assertStatus(200);
    }


    public function test_user__can_favorite_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('products.toggleFavorite',['product' => $product->id,
        ]));

        $response->assertStatus(302);

        $this->assertDatabaseHas('favorites',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);


    }


    public function test_favorited_product_is_recognized_as_favorited()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('items.detail',[
            'product' => $product->id,
        ]));

        $response->assertStatus(200);

        $response->assertViewHas('isFavorited',true);
    }

    public function test_user__can_unfavorite_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->actingAs($user);

        $this->post(route('products.toggleFavorite',[
            'product' => $product->id,
        ]));

        $this->assertDatabaseMissing('favorites',[
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);


    }
}
