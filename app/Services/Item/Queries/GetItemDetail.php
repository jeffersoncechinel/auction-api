<?php

namespace App\Services\Item\Queries;

use App\Common\Helpers\DateTimeHelper;
use App\Models\Bid;
use App\Models\Item;
use App\Models\UserAutoBidding;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
        if (! $item = Item::query()->find($itemId)) {
            throw new Exception('Item doest not exists.');
        }

        $data = $item->toArray();
        $data['auto_bidding'] = $this->isAutoBidding($itemId);
        $data['history'] = $this->getBidHistory($itemId);
        $data['finished_at'] = DateTimeHelper::datetimeFromUTC($data['finished_at'], 'America/Sao_Paulo');

        return $data;
    }

    /**
     * @param $itemId
     * @return false|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|int|mixed
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

        return $bids;
    }
}
