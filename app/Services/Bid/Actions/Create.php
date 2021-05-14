<?php

namespace App\Services\Bid\Actions;

use App\Models\Bid;
use App\Services\Bid\Validations\Validator;
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
     * @param $amount
     * @return bool
     * @throws Exception
     */
    public function execute($itemId, $amount)
    {
        try {
            DB::beginTransaction();

            (new Validator($this->userId, $itemId, $amount))
                ->isBiddingOpen()
                ->isUserOutBid()
                ->isBidAmountHigherThanCurrent();

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
     */
    protected function saveBid($itemId, $amount)
    {
        $model = new Bid();
        $model->item_id = $itemId;
        $model->user_id = $this->userId;
        $model->amount = $amount;
        $model->save();
        $model->refresh();

        $model->item->final_price = $amount;
        $model->item->save();
    }
}
