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
        $relations = [
            '腕時計' => ['ファッション','メンズ'],
            'HDD' => ['家電'],
            '玉ねぎ3束' => ['キッチン'],
            '革靴' => ['ファッション', 'メンズ'],
            'ノートPC' => ['家電'],
            'マイク' => ['家電'],
            'ショルダーバッグ' => ['ファッション','メンズ','レディース'],
            'タンブラー' => ['キッチン'],
            'コーヒーミル' => ['キッチン'],
            'メイクセット' => ['コスメ'],
        ];

        foreach ($relations as $productName => $categoryNames) {
            $product = Product::where('name',$productName)->firstOrFail();

            foreach ($categoryNames as $categoryName) {
                $category = Category::where('name',$categoryName)->firstOrFail();

                DB::table('category_product')->insert([
                    'product_id' => $product->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
