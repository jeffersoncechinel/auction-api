<?php

namespace App\Services\Bid\Validations;

use App\Services\Bid\Validations\Rules\HasEnoughCreditForAutoBid;
use App\Services\Bid\Validations\Rules\IsBidAmountHigherThanCurrent;
use App\Services\Bid\Validations\Rules\IsBiddingOpen;
use App\Services\Bid\Validations\Rules\IsUserOutBid;
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

    /**
     * @return $this
     * @throws Exception
     */
    public function isBiddingOpen()
    {
        (new IsBiddingOpen($this->itemId))->execute();

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function isUserOutBid()
    {
        (new IsUserOutBid($this->itemId, $this->userId))->execute();

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function isBidAmountHigherThanCurrent()
    {
        (new IsBidAmountHigherThanCurrent($this->itemId, $this->amount))->execute();

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function hasEnoughCreditForAutoBid()
    {
        (new HasEnoughCreditForAutoBid($this->amount, $this->userId))->execute();

        return $this;
    }
}
