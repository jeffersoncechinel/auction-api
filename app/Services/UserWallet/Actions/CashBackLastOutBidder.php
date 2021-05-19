<?php

namespace App\Services\UserWallet\Actions;

use App\Models\UserWallet;
use App\Services\Bid\Queries\LastBidByItem;

class CashBackLastOutBidder
{
    /**
     * @param float $amount
     * @param int $itemId
     * @return bool
     */
    public function execute(float $amount, int $itemId)
    {
        $lastBidder = LastBidByItem::execute($itemId);

        if (! $lastBidder) {
            return false;
        }

        $wallet = UserWallet::where(['user_id' => $lastBidder->user_id])->first();

        if ($wallet) {
            $wallet->amount_remaining += $amount - 1;
            $wallet->save();


        }

        return true;
    }
}
