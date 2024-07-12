<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'user_name' => 'retta.grady',
                'password' => '$NfH\\yXRx\"h-;frXV',
                'name' => 'Sedrick Jast II',
                'role' => 'Quản lý',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'wwest',
                'password' => 'vvw8M&X9%1{9)3r;#*',
                'name' => 'Adella Parker',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'broderick24',
                'password' => 'H1mms=D+0LX}k\'dH',
                'name' => 'Joe Halvorson',
                'role' => 'Thu ngân',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'oscar.heidenreich',
                'password' => '%/V*r]{oN,hW',
                'name' => 'Lucy Satterfield',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'wkuhlman',
                'password' => 'aQG@<$Pz4ID',
                'name' => 'Prof. Timmy Heathcote PhD',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'jeanne.bins',
                'password' => '>rkaPw6*2S]w',
                'name' => 'Luisa Jakubowski',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'plarson',
                'password' => 'p/23>1UVlSEcuXrf',
                'name' => 'Dr. Ewald Doyle',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'abshire.celestine',
                'password' => '|&Q%-\K$0mG',
                'name' => 'Karli Hermiston',
                'role' => 'Quản lý',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongtn2',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Thu ngân',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongdb2',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Đầu bếp',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongpv2',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongtn',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Thu ngân',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongdb',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Đầu bếp',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongpv',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Phục vụ',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
            [
                'user_name' => 'vuongql',
                'password' => '12345678',
                'name' => 'Vuong',
                'role' => 'Quản lý',
                'created_at' => '2024-07-12 23:23:22',
                'updated_at' => '2024-07-12 23:23:22',
            ],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
        // $faker = Faker::create();
        // for ($i=0; $i < 15; $i++) { 
        //     Account::create([
        //         'user_name'=>$faker->userName(),
        //         'password'=>$faker->password(),
        //         'name'=>$faker->name(),
        //         'role'=>$faker->randomElement(['Đầu bếp', 'Quản lý', 'Thu ngân', 'Phục vụ']),
        //     ]);
        // }
        
        // $account1 = new Account([
        //     'user_name' => 'retta.grady',
        //     'password' => '$NfH\\yXRx\"h-;frXV',
        //     'name' => 'Sedrick Jast II',
        //     'role' => 'Quản lý',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account2 = new Account([
        //     'user_name' => 'wwest',
        //     'password' => 'vvw8M&X9%1{9)3r;#*',
        //     'name' => 'Adella Parker',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account3 = new Account([
        //     'user_name' => 'broderick24',
        //     'password' => 'H1mms=D+0LX}k\'dH',
        //     'name' => 'Joe Halvorson',
        //     'role' => 'Thu ngân',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account4 = new Account([
        //     'user_name' => 'oscar.heidenreich',
        //     'password' => '%/V*r]{oN,hW',
        //     'name' => 'Lucy Satterfield',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account5 = new Account([
        //     'user_name' => 'wkuhlman',
        //     'password' => 'aQG@<$Pz4ID',
        //     'name' => 'Prof. Timmy Heathcote PhD',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account6 = new Account([
        //     'user_name' => 'jeanne.bins',
        //     'password' => '>rkaPw6*2S]w',
        //     'name' => 'Luisa Jakubowski',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account7 = new Account([
        //     'user_name' => 'plarson',
        //     'password' => 'p/23>1UVlSEcuXrf',
        //     'name' => 'Dr. Ewald Doyle',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account8 = new Account([
        //     'user_name' => 'abshire.celestine',
        //     'password' => '|&Q%-\K$0mG',
        //     'name' => 'Karli Hermiston',
        //     'role' => 'Quản lý',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account9 = new Account([
        //     'user_name' => 'vuongtn2',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Thu ngân',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account10 = new Account([
        //     'user_name' => 'vuongdb2',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Đầu bếp',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account11 = new Account([
        //     'user_name' => 'vuongpv2',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account12 = new Account([
        //     'user_name' => 'vuongtn',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Thu ngân',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account13 = new Account([
        //     'user_name' => 'vuongdb',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Đầu bếp',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account14 = new Account([
        //     'user_name' => 'vuongpv',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Phục vụ',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $account15 = new Account([
        //     'user_name' => 'vuongql',
        //     'password' => '12345678',
        //     'name' => 'Vuong',
        //     'role' => 'Quản lý',
        //     'created_at' => '2024-07-12 23:23:22',
        //     'updated_at' => '2024-07-12 23:23:22',
        // ]);
        // $accounts = [
        //     $account1, $account2, $account3, $account4, $account5, $account6,
        //     $account7, $account8, $account9, $account10, $account11, $account12,
        //     $account13, $account14, $account15,
        // ];        

        // foreach ($accounts as $value) {
        //     Account::create($value);
        // }
    }
}
