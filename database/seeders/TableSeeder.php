<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) { 
            Table::create([
                'table_name'=>"Bàn ".$i,
                'table_status'=>$faker->randomElement(['Inactive', 'Empty', 'Serving']),
            ]);
        }
    }
}
