<?php

namespace App\Services\UserAutoBidding\Queries;

use App\Models\UserAutoBidding;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GetAutoBidItemsByUser
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return UserAutoBidding[]|Builder[]|Collection
     */
    public function execute()
    {
        return UserAutoBidding::query()
            ->with('item')
            ->where([
                'user_id' => $this->userId,
                'is_active' => UserAutoBidding::STATUS_ACTIVE
            ])->get();
    }
}
