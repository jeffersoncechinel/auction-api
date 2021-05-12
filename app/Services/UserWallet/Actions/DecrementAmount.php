<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;

class DecrementAmount extends AbstractAction
{
    public function execute(int $amount = 1)
    {
        $model = UserWallet::query()->find($this->userId);

        if (! $model->decrementAmount($amount)) {
            return false;
        }

        $model->save();

        return true;
    }
}
