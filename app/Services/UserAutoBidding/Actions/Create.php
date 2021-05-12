<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Models\Bid;
use App\Models\Item;
use App\Services\Bid\Queries\LastBidByItem;
use App\Services\Bid\Rules\Validator;
use App\Services\UserWallet\Actions\DecrementAmount;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class Create
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function execute($itemId, $amount = 1)
    {
        try {
            DB::beginTransaction();

            (new Validator($this->userId, $itemId, $amount))
                ->isBiddingOpen()
                ->isHighestBid()
                ->isAmountHigherThanCurrentPrice();

            $this->saveBid($itemId, $amount);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }

        return true;
    }

    protected function saveBid($itemId, $amount)
    {
        $model = new Bid();
        $model->item_id = $itemId;
        $model->user_id = $this->userId;
        $model->amount = $amount;
        $model->save();

        $model->item->updateFinalPrice($amount);
        $model->item->save();

        // decrement from wallet
        if (! (new DecrementAmount($this->userId))->execute($amount)) {
            throw new Exception('Not enough money for the bid.');
        }
    }
}
