<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Condition;
use App\Models\Favorite;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_index_displays_all_products()
    {
        $response = $this->get('/',);

        $response->assertStatus(200);
    }

    public function test_sold_products_display_sold_label()
    {
        $condition = Condition::factory()->create();

        Product::factory()->create([
            'condition_id' => $condition->id,
            'status' => 'sold',
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function test_own_products_are_not_displayed_in_product_index()
    {
        $user = User::factory()->create();

        $ownProduct = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $otherProduct = Product::factory()->create([
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }


    public function test_mylist_page_can_be_displayed()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('items.index'));

        $response->assertStatus(200);
    }

    public function test_only_favorited_products_are_displayed()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedProduct = Product::factory()->create([
            'name' => 'いいねした商品',
        ]);

        $notLikedProduct = Product::factory()->create([
            'name' => 'いいねしてない商品',
        ]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしてない商品');
    }

    public function test_sold_products_display_sold_label_in_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $soldProduct = Product::factory()->create([
            'name' =>'売れた商品',
            'status' => 'sold',
        ]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'product_id' => $soldProduct->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');
    }


    public function test_mylist_is_empty_for_guest()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('商品');
    }

    public function test_products_can_be_searched_by_partial_name()
    {
        $condition = Condition::factory()->create();

        Product::factory()->create([
            'name' => '写真集',
            'condition_id' => $condition->id,
        ]);

        Product::factory()->create([
            'name' => 'コーヒー',
            'condition_id' => $condition->id,
        ]);

        $response = $this->get('/?keyword=写真');


        $response->assertStatus(200);
        $response->assertSee('写真集');
        $response->assertDontSee('コーヒー');

    }

    public function test_search_keyword_is_kept_when_switching_to_mylist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $condition = Condition::factory()->create();

        $picture = Product::factory()->create([
            'name' => '写真集',
            'condition_id' => $condition->id,
        ]);

        $coffee = Product::factory()->create([
            'name' => 'コーヒー',
            'condition_id' => $condition->id,
        ]);

        Favorite::factory()->create([
            'user_id' => $user->id,
            'product_id' => $picture->id,
        ]);

        $response = $this->get('/?tab=mylist&keyword=写真');

        $response->assertStatus(200);

    }
}