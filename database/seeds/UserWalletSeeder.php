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
        if (!UserWallet::find(1)) {
            $model = new UserWallet();
            $model->fill([
                'user_id' => 1,
                'maximum_amount' => 12000,
                'amount_remaining' => 12000,
            ])->save();
        }

        if (!UserWallet::find(2)) {
            $model = new UserWallet();
            $model->fill([
                'user_id' => 2,
                'maximum_amount' => 1500,
                'amount_remaining' => 1500,
            ])->save();
        }
    }
}
