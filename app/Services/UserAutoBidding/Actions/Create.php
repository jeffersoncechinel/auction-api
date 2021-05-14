<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Models\Bid;
use App\Models\Item;
use App\Services\Bid\Validations\Validator;
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

    /**
     * @param $itemId
     * @param int $amount
     * @return bool
     * @throws Exception
     */
    public function execute($itemId, $amount = 1)
    {
        try {
            DB::beginTransaction();

            (new Validator($this->userId, $itemId, $amount))
                ->isBiddingOpen()
                ->isUserOutBid()
                ->hasEnoughCreditForAutoBid();

            $this->saveBid($itemId, $amount);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }

        return true;
    }

    /**
     * @param $itemId
     * @param $amount
     * @throws Exception
     */
    protected function saveBid($itemId, $amount)
    {
        // decrement from wallet
        if (! (new DecrementAmount($this->userId))->execute($amount)) {
            throw new Exception('Not enough credit for the bid.');
        }

        $finalPrice = Item::find($itemId)->final_price;
        $model = new Bid();
        $model->item_id = $itemId;
        $model->user_id = $this->userId;
        $model->amount = $finalPrice + $amount;
        $model->save();

        $model->item->updateFinalPrice($amount);
        $model->item->save();

    }
}
