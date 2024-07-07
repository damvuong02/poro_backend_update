<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Nette\Utils\Random;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $foodIds = Food::pluck('id');
        $billIds = Bill::pluck('id');

        for ($i = 0; $i < 50; $i++) {
            $foodId = $faker->randomElement($foodIds);
            $food = Food::find($foodId);

            Order::create([
                'food_id' => $foodId,
                'bill_id' => $faker->randomElement($billIds),
                'quantity' => random_int(1, 10),
                'price' => $food->price,
                'order_status' => $faker->randomElement(['New', 'Cooking', 'Done']),
                'note' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
