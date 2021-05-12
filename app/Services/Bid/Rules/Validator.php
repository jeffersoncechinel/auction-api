<?php

namespace App\Services\Bid\Rules;

use App\Models\Item;
use App\Services\Bid\Queries\LastBidByItem;
use App\Services\UserWallet\Queries\GetWalletAmount;
use Exception;

class Validator
{
    public $userId;
    public $itemId;
    public $amount;

    public function __construct($userId, $itemId, $amount)
    {
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->amount = $amount;
    }

    // abort if the auction for the item has already finished
    public function isBiddingOpen()
    {
        if (! Item::canBid($this->itemId)) {
            throw new Exception('The auction for this item has finished.');
        }

        return $this;
    }

    // a user cannot bid if already have the highest bid
    public function isHighestBid()
    {
        if ($bid = (new LastBidByItem())->execute($this->itemId)) {
            if ($bid->user_id === $this->userId) {
                throw new Exception('You already have the highest bid for this item.');
            }
        }

        return $this;
    }

    // making sure the bid is greater than the current price
    public function isAmountHigherThanCurrentPrice()
    {
        $currentBidPrice = (new LastBidByItem())->execute($this->itemId);
        if ($currentBidPrice) {
            if ($this->amount <= $currentBidPrice->final_price) {
                throw new Exception('The item price has changed before you bid. Please try again.');
            }
        }

        return $this;
    }

    // if user does not have enough money he cannot bid.
    public function hasEnoughMoneyToBid()
    {
        if ((new GetWalletAmount($this->userId))->execute() < $this->amount) {
            throw new Exception('User has not enough money to bid.');
        }
    }
}
