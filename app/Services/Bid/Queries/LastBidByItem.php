<?php

namespace App\Services\Bid\Queries;

use App\Models\Bid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LastBidByItem
{
    /**
     * @param $itemId
     * @return Bid|Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function execute($itemId)
    {
        return Bid::where([
            'item_id' => $itemId
        ])->orderBy('id', 'desc')->first();
    }
}
