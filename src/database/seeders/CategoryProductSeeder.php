<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::pluck('id','name');
        $categories = Category::pluck('id','name');

        DB::table('category_product')->insert([
            [
                'product_id' => $products['腕時計'],
                'category_id' => $categories['ファッション'],
            ],
            [
                'product_id' => $products['腕時計'],
                'category_id' => $categories['メンズ'],
            ],
            [
                'product_id' => $products['HDD'],
                'category_id' => $categories['家電'],
            ],
            [
                'product_id' => $products['玉ねぎ3束'],
                'category_id' => $categories['キッチン'],
            ],
            [
                'product_id' => $products['革靴'],
                'category_id' => $categories['ファッション'],
            ],
            [
                'product_id' => $products['革靴'],
                'category_id' => $categories['メンズ'],
            ],
            [
                'product_id' => $products['ノートPC'],
                'category_id' => $categories['家電'],
            ],
            [
                'product_id' => $products['マイク'],
                'category_id' => $categories['家電'],
            ],
            [
                'product_id' => $products['ショルダーバッグ'],
                'category_id' => $categories['ファッション'],
            ],
            [
                'product_id' => $products['ショルダーバッグ'],
                'category_id' => $categories['メンズ'],
            ],
            [
                'product_id' => $products['ショルダーバッグ'],
                'category_id' => $categories['レディース'],
            ],
            [
                'product_id' => $products['タンブラー'],
                'category_id' => $categories['キッチン'],
            ],
            [
                'product_id' => $products['コーヒーミル'],
                'category_id' => $categories['キッチン'],
            ],
            [
                'product_id' => $products['メイクセット'],
                'category_id' => $categories['コスメ'],
            ],
        ]);
    }
}
