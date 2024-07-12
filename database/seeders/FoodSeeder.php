<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            [
                'food_name' => 'Cà phê sữa đá',
                'category_id' => 1,
                'price' => 20000,
                'quantity' => 100,
                'food_image' => 'https://example.com/ca-phe-sua-da.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => false,
            ],
            [
                'food_name' => 'Trà đá',
                'category_id' => 1,
                'price' => 5000,
                'quantity' => 200,
                'food_image' => 'https://example.com/tra-da.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => false,
            ],
            [
                'food_name' => 'Sinh tố bơ',
                'category_id' => 1,
                'price' => 30000,
                'quantity' => 50,
                'food_image' => 'https://example.com/sinh-to-bo.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Nước mía',
                'category_id' => 1,
                'price' => 15000,
                'quantity' => 120,
                'food_image' => 'https://example.com/nuoc-mia.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => false,
            ],
            [
                'food_name' => 'Sữa đậu nành',
                'category_id' => 1,
                'price' => 10000,
                'quantity' => 80,
                'food_image' => 'https://example.com/sua-dau-nanh.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => false,
            ],
            [
                'food_name' => 'Gỏi cuốn',
                'category_id' => 2,
                'price' => 25000,
                'quantity' => 70,
                'food_image' => 'https://example.com/goi-cuon.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Nộm hoa chuối',
                'category_id' => 2,
                'price' => 30000,
                'quantity' => 60,
                'food_image' => 'https://example.com/nom-hoa-chuoi.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Gỏi đu đủ',
                'category_id' => 2,
                'price' => 20000,
                'quantity' => 50,
                'food_image' => 'https://example.com/goi-du-du.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Gỏi xoài',
                'category_id' => 2,
                'price' => 25000,
                'quantity' => 80,
                'food_image' => 'https://example.com/goi-xoai.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Nộm rau muống',
                'category_id' => 2,
                'price' => 20000,
                'quantity' => 90,
                'food_image' => 'https://example.com/nom-rau-muong.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Chả giò',
                'category_id' => 3,
                'price' => 30000,
                'quantity' => 100,
                'food_image' => 'https://example.com/cha-gio.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Nem cuốn',
                'category_id' => 3,
                'price' => 25000,
                'quantity' => 120,
                'food_image' => 'https://example.com/nem-cuon.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Bánh xèo',
                'category_id' => 3,
                'price' => 40000,
                'quantity' => 70,
                'food_image' => 'https://example.com/banh-xeo.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Chả cá lã vọng',
                'category_id' => 3,
                'price' => 50000,
                'quantity' => 60,
                'food_image' => 'https://example.com/cha-ca-la-vong.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Bánh khọt',
                'category_id' => 3,
                'price' => 35000,
                'quantity' => 80,
                'food_image' => 'https://example.com/banh-khot.jpg',
                'food_unit' => 'Đĩa',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Chè ba màu',
                'category_id' => 4,
                'price' => 15000,
                'quantity' => 90,
                'food_image' => 'https://example.com/che-ba-mau.jpg',
                'food_unit' => 'Bát',
                'quantity_sold' => 0,
                'need_cooking' => false,
            ],
            [
                'food_name' => 'Bánh flan',
                'category_id' => 4,
                'price' => 20000,
                'quantity' => 100,
                'food_image' => 'https://example.com/banh-flan.jpg',
                'food_unit' => 'Cái',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Canh chua cá',
                'category_id' => 5,
                'price' => 45000,
                'quantity' => 50,
                'food_image' => 'https://example.com/canh-chua-ca.jpg',
                'food_unit' => 'Bát',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Canh bầu nấu tôm',
                'category_id' => 5,
                'price' => 40000,
                'quantity' => 60,
                'food_image' => 'https://example.com/canh-bau-nau-tom.jpg',
                'food_unit' => 'Bát',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Canh khoai mỡ',
                'category_id' => 5,
                'price' => 35000,
                'quantity' => 70,
                'food_image' => 'https://example.com/canh-khoai-mo.jpg',
                'food_unit' => 'Bát',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
            [
                'food_name' => 'Canh mướp đắng nhồi thịt',
                'category_id' => 5,
                'price' => 40000,
                'quantity' => 50,
                'food_image' => 'https://example.com/canh-muop-dang-nhoi-thit.jpg',
                'food_unit' => 'Bát',
                'quantity_sold' => 0,
                'need_cooking' => true,
            ],
        ];

        // Insert the food data
        foreach ($foods as $food) {
            Food::create($food);
        }
        
    }
}
