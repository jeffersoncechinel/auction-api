<?php

namespace App\Services\UserWallet\Queries;

use App\Models\UserWallet;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;

class GetWalletAmount
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
        $data = UserWallet::query()->where([
            'user_id' => $this->userId,
        ])->first();

        if (! $data) {
            return 0;
        }

        return $data->maximum_amount;
    }
}
