<?php

namespace App\Services\Bid\Queries;

use App\Models\Bid;

class TotalBidsByUserForAnItem
{
    /**
     * @return int
     */
    public static function execute($itemId, $userId)
    {
        return Bid::where([
            'user_id' => $userId,
            'item_id' => $itemId,
        ])->count();
    }
}
