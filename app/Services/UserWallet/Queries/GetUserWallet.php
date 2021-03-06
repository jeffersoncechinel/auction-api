<?php

namespace App\Services\UserWallet\Queries;

use App\Models\UserWallet;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;

class GetUserWallet
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return HigherOrderBuilderProxy|int|mixed
     */
    public function execute()
    {
        return UserWallet::query()->where([
            'user_id' => $this->userId,
        ])->first();
    }

}
