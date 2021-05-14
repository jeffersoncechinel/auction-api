<?php

namespace App\Services\Bid\Validations\Rules;

use App\Services\Bid\Queries\LastBidByItem;
use Exception;

class IsBidAmountHigherThanCurrent
{
    public $itemId;
    public $amount;

    public function __construct($itemId, $amount)
    {
        $this->itemId = $itemId;
        $this->amount = $amount;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function execute()
    {
        // making sure the bid is greater than the current price
        if ($currentBidPrice = LastBidByItem::execute($this->itemId)) {
            if ($this->amount <= $currentBidPrice->item->final_price) {
                throw new Exception('The bid amount must be higher than current bid.');
            }
        }

        return true;
    }

    public static function check($itemId, $amount)
    {
        try {
            (new self($itemId, $amount))->execute();
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}
