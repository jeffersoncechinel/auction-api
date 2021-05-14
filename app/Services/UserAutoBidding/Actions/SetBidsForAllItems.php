<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Models\UserAutoBidding;
use Exception;

class SetBidsForAllItems
{
    /**
     * @return bool
     */
    public function execute()
    {
        $models = UserAutoBidding::where([
            'is_active' => UserAutoBidding::STATUS_ACTIVE,
        ])->get()->toArray();

        shuffle($models);

        foreach ($models as $model) {
            try {
                (new Create($model['user_id']))->execute($model['item_id']);
            } catch (Exception $exception) {
                // log errors some where
                echo $exception->getMessage() . PHP_EOL;
            }

            sleep(rand(8,10));
        }

        return true;
    }
}
