<?php

namespace App\Services\Item\Queries;

use App\Models\Item;
use Exception;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Support\HigherOrderCollectionProxy;

class GetCurrentPrice
{
    /**
     * @param $itemId
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed|number
     * @throws Exception
     */
    public static function execute($itemId)
    {
        if (! $item = Item::query()->find($itemId)) {
            throw new Exception('Item doest not exists.');
        }

        return $item->final_price;
    }
}
