<?php

namespace App\Models;

use App\Common\Helpers\DateTimeHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 * @package App\Models
 * @property number $final_price
 */
class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'initial_price',
        'final_price',
        'started_at',
        'finished_at',
    ];
    protected $dates = ['deleted_at'];

    public static function canBid($id)
    {
        return self::where(['id' => $id])->where('finished_at', '>=', DateTimeHelper::now())->first();
    }

    /**
     * @return HasMany
     */
    public function bids()
    {
        return $this->hasMany(Bid::class, 'item_id', 'id');
    }

    public function userAutoBiddings()
    {
        return $this->hasMany(UserAutoBidding::class, 'item_id', 'id');
    }

    /**
     * @param $amount
     */
    public function updateFinalPrice($amount)
    {
        $this->final_price += $amount;
    }
}
