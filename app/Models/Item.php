<?php

namespace App\Models;

use App\Common\Helpers\DateTimeHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Item
 * @package App\Models
 * @property number $final_price
 */
class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'image_url', 'initial_price',
        'final_price', 'started_at', 'finished_at'
    ];

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids()
    {
        return $this->hasMany(Bid::class, 'item_id', 'id');
    }

    public static function canBid($id)
    {
        return self::where(['id' => $id])->where('finished_at', '>=', DateTimeHelper::now())->first();
    }

    /**
     * @param $amount
     */
    public function updateFinalPrice($amount)
    {
        $this->final_price += $amount;
    }
}
