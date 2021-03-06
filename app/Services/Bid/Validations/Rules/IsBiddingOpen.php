<?php

namespace App\Services\Bid\Validations\Rules;

use App\Models\Item;
use Exception;

class IsBiddingOpen
{
    public $itemId;

    /**
     * IsBiddingOpen constructor.
     * @param $itemId
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function execute()
    {
        // abort if the auction for the item has already finished
        if (! Item::canBid($this->itemId)) {
            throw new Exception('The auction for this item has finished.');
        }

        return true;
    }

    public static function check($itemId)
    {
        try {
            (new self($itemId))->execute();
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}
