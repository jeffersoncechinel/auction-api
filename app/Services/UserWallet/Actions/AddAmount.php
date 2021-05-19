<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AddAmount extends AbstractAction
{
    /**
     * @param float $amount
     * @return UserWallet|UserWallet[]|Builder|Builder[]|Collection|Model|null
     * @throws Exception
     */
    public function execute(float $amount)
    {
        $model = UserWallet::query()->find($this->userId);

        $spent = $model->maximum_amount - $model->amount_remaining;

        if ($amount < $spent) {
            throw new Exception('You cannot set maximum amount lower than current spent: $' . number_format($spent, 2));
        }

        $model->maximum_amount = $amount;
        $model->amount_remaining = $amount - $spent;

        $model->save();
        $model->refresh();

        return $model;
    }
}
