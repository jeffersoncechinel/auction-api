<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Models\UserAutoBidding;
use App\Services\Bid\Validations\Rules\IsBiddingOpen;

class EnableAutoBid
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param int $itemId
     * @return bool
     * @throws \Exception
     */
    public function execute(int $itemId)
    {
        (new IsBiddingOpen($itemId))->execute();

        $model = UserAutoBidding::query()->where([
            'user_id' => $this->userId,
            'item_id' => $itemId,
        ])->first();

        if (! $model) {
            $model = new UserAutoBidding();
            $model->user_id = $this->userId;
            $model->item_id = $itemId;
        }

        $model->is_active = UserAutoBidding::STATUS_ACTIVE;
        $model->save();

        return true;
    }
}
