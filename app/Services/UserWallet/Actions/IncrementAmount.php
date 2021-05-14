<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class IncrementAmount extends AbstractAction
{
    /**
     * @param int $amount
     * @return UserWallet|UserWallet[]|false|Builder|Builder[]|Collection|Model
     */
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
