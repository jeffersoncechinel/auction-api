<?php

namespace App\Services\Bid\Queries;

use App\Models\Bid;

class BidsByUser
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function execute()
    {
        return Bid::where(['user_id' => $this->userId])->count();
    }
}
