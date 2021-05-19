<?php

namespace App\Services\Item\Queries;

use App\Common\Helpers\DateTimeHelper;
use App\Models\Auth\User;
use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Search
{
    public $userId;
    public $searchText;
    public $priceSort;
    public $perPage = 10;
    const SORT_PRICE_DESC = 'desc';
    const SORT_PRICE_ASC = 'asc';

    /**
     * @return LengthAwarePaginator
     */
    public function execute()
    {
        $query = Item::query()
            ->with(['bids'])
            ->with(['userAutoBiddings']);

        if ($this->searchText) {
            $query->where('name', 'like', '%' . $this->searchText . '%');
            $query->orWhere('description', 'like', '%' . $this->searchText . '%');
        }

        if ($this->priceSort) {
            $query->orderBy('final_price', $this->priceSort);
        }

        $paginator = $query->paginate($this->perPage);

        $paginator->getCollection()->transform(function ($model) {
            $model->finished_at = DateTimeHelper::datetimeFromUTC($model['finished_at']);
            $model = $this->lastBidByDto($model);
            $model = $this->autoBiddingDto($model);

            return $model;
        });

        return $paginator;
    }

    public function lastBidByDto($model)
    {
        if (isset($model['bids'][0])) {
            $bid = array_values(array_slice($model['bids']->toArray(), -1))[0];
            $model->last_bid_by = (new User())->findById($bid['user_id'])->username;
        } else {
            $model->last_bid_by = null;
        }

        return $model;
    }

    public function autoBiddingDto($model)
    {
        if (isset($model['userAutoBiddings'][0])) {
            $tmp = [];
            foreach ($model['userAutoBiddings'] as $autoBid) {
                if ($autoBid['user_id'] === \Auth::id()) {
                    $tmp[] = $autoBid;
                }
            }

            $autoBid = array_shift($tmp);
            $model->auto_bidding = (boolean)$autoBid['is_active'];
        } else {
            $model->auto_bidding = false;
        }
        unset($model['userAutoBiddings']);

        return $model;
    }
}
