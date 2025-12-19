<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Condition;
use App\Models\User;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'user_id' => 1,
            'condition_id' => Condition::where('name','良好')->value('id'),
            'name' => '腕時計',
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 2,
            'condition_id' => Condition::where('name','目立った傷や汚れなし')->value('id'),
            'name' => 'HDD',
            'brand_name' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 3,
            'condition_id' => Condition::where('name','やや傷や汚れあり')->value('id'),
            'name' => '玉ねぎ3束',
            'brand_name' => null,
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 4,
            'condition_id' => Condition::where('name','状態が悪い')->value('id'),
            'name' => '革靴',
            'brand_name' => null,
            'description' => 'クラシックなデザインの革靴',
            'price' => 4000,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 5,
            'condition_id' => Condition::where('name','良好')->value('id'),
            'name' => 'ノートPC',
            'brand_name' => null,
            'description' => '高性能なノートパソコン',
            'price' => 45000,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 6,
            'condition_id' => Condition::where('name','目立った傷や汚れなし')->value('id'),
            'name' => 'マイク',
            'brand_name' => null,
            'description' => '高音質のレコーディング用マイク',
            'price' => 8000,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 7,
            'condition_id' => Condition::where('name','やや傷や汚れあり')->value('id'),
            'name' => 'ショルダーバッグ',
            'brand_name' => null,
            'description' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 8,
            'condition_id' => Condition::where('name','状態が悪い')->value('id'),
            'name' => 'タンブラー',
            'brand_name' => null,
            'description' => '使いやすいタンブラー',
            'price' => 500,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 9,
            'condition_id' => Condition::where('name','良好')->value('id'),
            'name' => 'コーヒーミル',
            'brand_name' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'price' => 500,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'status' => '出品中',
        ]);
        Product::create([
            'user_id' => 10,
            'condition_id' => Condition::where('name','目立った傷や汚れなし')->value('id'),
            'name' => 'メイクセット',
            'brand_name' => null,
            'description' => '便利なメイクアップセット',
            'price' => 500,
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'status' => '出品中',

        ]);
    }
}
