<?php

namespace App\Services\Bid\Validations\Rules;

use App\Services\UserWallet\Queries\GetWalletAmount;
use Exception;

class HasEnoughCreditForAutoBid
{
    public $amount;
    public $userId;

    public function __construct($amount, $userId)
    {
        $this->amount = $amount;
        $this->userId = $userId;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        // if user does not have enough credit he cannot bid.
        if ((new GetWalletAmount($this->userId))->execute() < $this->amount) {
            throw new Exception('User has not enough credit to bid.');
        }
    }
}
