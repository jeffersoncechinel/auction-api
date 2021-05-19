<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;

class DecrementAmount extends AbstractAction
{
    /**
     * @param int $amount
     * @return bool
     */
    public function execute(int $amount = 1)
    {
        $model = UserWallet::query()->find($this->userId);

        if ($model->amount_remaining <= 0 || $model->amount_remaining < $amount) {
            return false;
        }

        $model->amount_remaining -= $amount;
        $model->save();

        return true;
    }
}
