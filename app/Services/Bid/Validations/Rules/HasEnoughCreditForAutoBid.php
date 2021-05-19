<?php

namespace App\Services\Bid\Validations\Rules;

use App\Services\UserWallet\Queries\GetUserWallet;
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
     * @return bool
     * @throws Exception
     */
    public function execute()
    {
        // if user does not have enough credit he cannot bid.
        $wallet = (new GetUserWallet($this->userId))->execute();

        if ($wallet->amount_remaining < $this->amount) {
            throw new Exception('Your current amount is not enough for auto bid.');
        }

        return true;
    }

    public static function check($amount, $userId)
    {
        try {
            (new self($amount, $userId))->execute();
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}
