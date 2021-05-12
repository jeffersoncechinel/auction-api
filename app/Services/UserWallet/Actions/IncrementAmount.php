<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;

class IncrementAmount extends AbstractAction
{
    public function execute(int $amount = 1)
    {
        if (! $model = UserWallet::query()->find($this->userId)) {
            $model = new UserWallet();
            $model->user_id = $this->userId;
        }

        if (! $model->incrementAmount($amount)) {
            return false;
        }

        $model->save();
        $model->refresh();

        return $model;
    }
}
