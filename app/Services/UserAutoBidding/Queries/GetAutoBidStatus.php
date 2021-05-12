<?php

namespace App\Services\UserAutoBidding\Queries;

use App\Models\UserAutoBidding;

class GetAutoBidStatus
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param $itemId
     * @return bool
     */
    public function execute($itemId)
    {
        $data = UserAutoBidding::query()->where([
            'item_id' => $itemId,
            'user_id' => $this->userId,
        ])->first();

        if (! $data) {
            $data = 0;
        } else {
            $data = $data->is_active;
        }

        return (bool)$data;
    }
}
