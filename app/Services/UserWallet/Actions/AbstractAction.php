<?php

namespace App\Services\UserWallet\Actions;

abstract class AbstractAction
{
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
