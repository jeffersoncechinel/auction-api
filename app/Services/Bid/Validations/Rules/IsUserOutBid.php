<?php

namespace App\Services\Bid\Validations\Rules;

use App\Services\Bid\Queries\LastBidByItem;
use Exception;

class IsUserOutBid
{
    public $itemId;
    public $userId;

    /**
     * isUserOutBid constructor.
     * @param $itemId
     * @param $userId
     */
    public function __construct($itemId, $userId)
    {
        $this->itemId = $itemId;
        $this->userId = $userId;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function execute()
    {
        // a user cannot bid if already have the highest bid
        if ($bid = (new LastBidByItem())->execute($this->itemId)) {
            if ($bid->user_id === $this->userId) {
                throw new Exception('You already have the highest bid for this item.');
            }
        }

        return $this;
    }
}
