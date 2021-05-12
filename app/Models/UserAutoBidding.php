<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAutoBidding extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function item()
    {
        return $this->hasOne(Item::class, 'item_id', 'id');
    }
}
