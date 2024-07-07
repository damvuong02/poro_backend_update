<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Table;
use App\Models\WaiterNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WaiterNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $tableIds = Table::pluck('id');
        $foodIds = Food::pluck('id');

        for ($i = 0; $i < 50; $i++) {
            WaiterNotification::create([
                'table_id' => $faker->randomElement($tableIds),
                'notification_status' => $faker->randomElement(['New', 'In Progress', 'Completed']),
                'food_id' => $faker->randomElement($foodIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
