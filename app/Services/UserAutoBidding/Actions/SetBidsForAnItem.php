<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Models\UserAutoBidding;
use Exception;

class SetBidsForAnItem
{
    /**
     * @param int $item
     * @return bool
     */
    public function execute(int $itemId)
    {
        $models = UserAutoBidding::query()->where([
            'item_id' => $itemId,
            'is_active' => UserAutoBidding::STATUS_ACTIVE,
        ])->get();

        foreach ($models as $model) {
            try {
                (new Create($model->user_id))->execute($model->item_id);
            } catch (Exception $exception) {
                // log errors some where
            }
        }

        return true;
    }
}
