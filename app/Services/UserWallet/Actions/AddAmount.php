<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;

class AddAmount extends AbstractAction
{
    /**
     * @param int $amount
     * @return bool
     */
    public function execute(int $amount)
    {
        $model = UserWallet::query()->find($this->userId);

        if (! $model->inccrementAmount($amount)) {
            return false;
        }

        return true;
    }
}
