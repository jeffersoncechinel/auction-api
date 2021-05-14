<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAutoBidding
 * @package App\Models
 */
class UserAutoBidding extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
