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
use Database\Seeders\ConditionSeeder;


class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    public function test_detail_page_can_be_displayed()
    {
        $condition = Condition::where('name','良好')->first();

        $product = Product::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $response = $this->get(route('items.detail',['item_id' => $product->id]));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee(number_format($product->price));
        $response->assertSee($product->description);
    }

    public function test_multiple_categories_are_displayed()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->seed(\Database\Seeders\CategorySeeder::class);

        $condition = Condition::where('name','良好')->first();

        $product = Product::factory()->create([
            'name' => '多カテゴリ商品',
            'condition_id' => $condition->id,
        ]);

        $category1 = Category::where('name','メンズ')->first();
        $category2 = Category::where('name','レディース')->first();

        $product->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('items.detail',$product));

        $response->assertStatus(200);

        $response->assertSee('メンズ');
        $response->assertSee('レディース');
    }

}
