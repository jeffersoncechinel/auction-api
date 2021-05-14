<?php

namespace App\Services\Item\Queries;

use App\Common\Helpers\DateTimeHelper;
use App\Models\Bid;
use App\Models\Item;
use App\Models\UserAutoBidding;
use App\Services\Bid\Queries\TotalBidsByUserForAnItem;
use App\Services\Bid\Validations\Rules\IsBiddingOpen;
use App\Services\Bid\Validations\Rules\IsUserOutBid;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;

class GetItemDetail
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param $itemId
     * @return array
     * @throws Exception
     */
    public function execute($itemId)
    {
        if (!$item = Item::query()->find($itemId)) {
            throw new Exception('Item doest not exists.');
        }

        $data = $item->toArray();
        $data['auto_bidding'] = $this->isAutoBidding($itemId);
        $data['history'] = $this->getBidHistory($itemId);
        $data['finished_at'] = DateTimeHelper::datetimeFromUTC($data['finished_at']);
        $data['status'] = $this->getStatus($itemId);

        return $data;
    }

    /**
     * @param $itemId
     * @return false|HigherOrderBuilderProxy|int|mixed
     */
    protected function isAutoBidding($itemId)
    {
        $autoBidding = false;
        $userAutoBidding = UserAutoBidding::query()->where([
            'user_id' => $this->userId,
            'item_id' => $itemId,
        ])->first();

        if ($userAutoBidding) {
            $autoBidding = $userAutoBidding->is_active;
        }

        return $autoBidding;
    }

    /**
     * @param $itemId
     * @return Bid[]|Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    protected function getBidHistory($itemId)
    {
        $bids = Bid::query()->where([
            'user_id' => $this->userId,
            'item_id' => $itemId,
        ])->orderBy('id', 'desc')->get();

        $data = [];

        foreach ($bids as $bid) {
            $bid->created_at = DateTimeHelper::datetimeFromUTC($bid->created_at);
            $data[] = $bid;
        }

        return $data;
    }

    protected function getStatus($itemId)
    {
        if (TotalBidsByUserForAnItem::execute($itemId, $this->userId) < 1) {
            return 'notbidding';
        }

        $userOutBid = IsUserOutBid::check($itemId, $this->userId);
        $isBiddingOpen = IsBiddingOpen::check($itemId);

        if ($userOutBid && !$isBiddingOpen) {
            return 'lost';
        } else if ($userOutBid) {
            return 'loosing';
        } else if ($isBiddingOpen) {
            return 'winning';
        } else {
            return 'won';
        }
    }
}
