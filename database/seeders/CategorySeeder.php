<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = ['Đồ uống', 'Salat', 'Khai vị', 'Tráng miệng', 'Canh', 'Món chính', 'Lẩu', 'Hải sản'];
        for ($i=0; $i < 8; $i++) { 
            Category::create([
                'category_name'=>$list[$i],
            ]);
        }
    }
}
