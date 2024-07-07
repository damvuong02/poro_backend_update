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
        $faker = Faker::create();
        //Trả về 1 mảng các value trong cột "id"
        $cates = Category::pluck('id');
        for ($i=0; $i < 15; $i++) {
            Food::create([
                'food_name'=>$faker->name(),
                'category_id'=>$faker->randomElement($cates),
                'price'=>random_int(10000, 300000),
                'quantity'=>random_int(100, 200),
                'food_image'=>null,
                'food_unit'=>$faker->randomElement(['Bát', 'Đĩa', 'Cái', 'Chai', 'Lon', 'Nồi']),
            ]);
        }
    }
}
