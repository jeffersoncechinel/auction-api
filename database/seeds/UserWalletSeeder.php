<?php

use App\Models\UserWallet;
use Illuminate\Database\Seeder;

class UserWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         UserWallet::create([
            'user_id' => 1,
            'maximum_amount' => 10,
        ]);

        UserWallet::create([
            'user_id' => 2,
            'maximum_amount' => 15,
        ]);
    }
}
