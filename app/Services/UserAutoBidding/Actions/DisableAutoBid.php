<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Models\UserAutoBidding;
use Exception;

class DisableAutoBid
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param int $itemId
     * @return bool
     * @throws Exception
     */
    public function execute(int $itemId)
    {
        $model = UserAutoBidding::query()->where([
            'user_id' => $this->userId,
            'item_id' => $itemId,
        ])->first();

        if (! $model) {
            throw new Exception('User has not enabled auto bidding.');
        }

        $model->is_active = UserAutoBidding::STATUS_INACTIVE;
        $model->save();

        return true;
    }
}
