<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\User;


class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_page_can_be_displayed()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('items.detail',['product' => $product->id]));

        $response->assertStatus(200);
    }

    public function test_multiple_categories_are_displayed()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $condition = Condition::factory()->create();

        $product = Product::factory()->create([
            'name' => '多カテゴリ商品',
            'condition_id' => $condition->id,
        ]);

        $category1 = Category::factory()->create(['name' => '本']);
        $category2 = Category::factory()->create(['name' => '写真集']);

        $product->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('items.detail',$product));

        $response->assertStatus(200);

        $response->assertSee('本');
        $response->assertSee('写真集');
    }

}
