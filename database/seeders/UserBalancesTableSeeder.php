<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBalancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = (new UserBalance())->getTable();

        if (DB::table($table)->exists()) {
            return;
        }

        $users = User::all();

        foreach ($users as $user) {
            DB::table('user_balances')->insert([
                'user_id' => $user->id,
                'balance' => fake()->randomFloat(2, 0, 10000),
            ]);
        }
    }
}
