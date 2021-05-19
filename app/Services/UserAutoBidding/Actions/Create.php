<?php

namespace App\Services\UserAutoBidding\Actions;

use App\Events\Bid\SendMessage;
use App\Models\Bid;
use App\Services\Bid\Validations\Rules\HasEnoughCreditForAutoBid;
use App\Services\Bid\Validations\Rules\IsBiddingOpen;
use App\Services\Bid\Validations\Rules\IsUserOutBid;
use App\Services\Item\Queries\GetCurrentPrice;
use App\Services\Item\Queries\GetItemDetail;
use App\Services\UserWallet\Actions\CashBackLastOutBidder;
use App\Services\UserWallet\Actions\DecrementAmount;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
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
     * @return bool
     * @throws Exception
     */
    public function execute($itemId)
    {
        try {
            DB::beginTransaction();

            $amount = GetCurrentPrice::execute($itemId) + 1;
            (new IsBiddingOpen($itemId))->execute();
            (new IsUserOutBid($itemId, $this->userId))->execute();
            (new HasEnoughCreditForAutoBid($amount, $this->userId))->execute();
            (new CashBackLastOutBidder())->execute($amount, $itemId);

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

        $model = new Bid();
        $model->item_id = $itemId;
        $model->user_id = $this->userId;
        $model->amount = $amount;
        $model->save();

        $model->item->final_price = $amount;
        $model->item->save();
        $model->item->refresh();

        $data = (new GetItemDetail($this->userId))->execute($model->item->id);
        $data = [
            'id' => $data['id'],
            'final_price' => $data['final_price'],
            'last_bid_by' => $data['last_bid_by'],
        ];

        Event::dispatch(new SendMessage($data));
    }
}
