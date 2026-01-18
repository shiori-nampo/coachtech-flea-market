<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\ConditionSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\CategorySeeder;


class ProductSellTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        parent::setUp();
        $this->seed(PaymentMethodSeeder::class);
        parent::setUp();
        $this->seed(CategorySeeder::class);
    }

    public function test_product_can_be_exhibited_with_valid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $category = Category::first();
        $condition = Condition::first();

        $imagePath = base_path('tests/Fixtures/test.jpg');

        $response = $this->post(route('items.store'),[
            'category_ids' => [$category->id],
            'condition_id' => $condition->id,
            'name' => '出品テスト商品',
            'description' => '商品の説明',
            'price' => 5000,
            'image' => new UploadedFile(
                $imagePath,
                'test.jpg',
                'image/jpeg',
                null,
                true
            )
        ]);

        $response->assertSessionHasNoErrors();

        $product = Product::where('name','出品テスト商品')->first();
        $this->assertNotNull($product);

        $this->assertDatabaseHas('category_product',[
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('items.index'));
    }
}
