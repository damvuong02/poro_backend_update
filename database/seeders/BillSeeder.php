<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Bill;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $accountIds = Account::pluck('id');
        $tableIds = Table::pluck('id');
        for ($i = 0; $i < 50; $i++) {
            Bill::create([
                'account_id' => $faker->randomElement($accountIds),
                'table_id' => $faker->randomElement($tableIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
