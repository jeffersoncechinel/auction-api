<?php

namespace App\Models;

// use App\Services\UserAutoBidding\Actions\SetBidsForAnItem;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bid
 * @package App\Models
 */
class Bid extends Model
{
    const DEFAULT_BID_VALUE = 1;

    protected $fillable = ['item_id', 'user_id', 'amount'];
    protected $attributes = ['amount' => self::DEFAULT_BID_VALUE];


    protected static function boot()
    {
        parent::boot();

        // execute auto bidding, probably use another approach for this in the future.
        static::created(function ($model) {
            //(new SetBidsForAnItem())->execute($model->item_id);
        });
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
