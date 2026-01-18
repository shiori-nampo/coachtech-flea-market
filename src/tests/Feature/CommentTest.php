<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use Database\Seeders\ConditionSeeder;
use App\Models\Condition;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
    }

    public function test_logined_in_user_can_post_comment()
    {
        $user = User::factory()->create();
        $condition = Condition::where('name','良好')->first();
        $product = Product::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(
            route('comments.store',['item_id' => $product->id,]),
            ['content' => 'テストコメント']
        );

        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'テストコメント',
        ]);
    }


    public function test_guest_user_cannot_post_comment()
    {
        $condition = Condition::where('name','良好')->first();
        $product = Product::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $response = $this->post(
            route('comments.store',['item_id' => $product->id]),
            ['content' => 'ゲストコメント']
        );

        $response->assertRedirect(route('login'));

    }


    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $condition = Condition::where('name','良好')->first();
        $product = Product::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(
            route('comments.store', ['item_id' => $product->id]),
            ['content' => '']
        );

        $response->assertSessionHasErrors(['content']);

    }

    public function test_comment_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $condition = Condition::where('name','良好')->first();
        $product = Product::factory()->create([
            'condition_id' => $condition->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(
            route('comments.store',['item_id' => $product->id]),['content' => str_repeat('あ',256)]
        );

        $response->assertSessionHasErrors(['content']);
    }

}
