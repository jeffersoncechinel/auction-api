<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 * @package App\Models
 * @property number $final_price
 */
class Item extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'image_url', 'initial_price', 'final_price', 'started_at', 'finished_at'];
    protected $dates = ['deleted_at'];

    public function bids()
    {
        return $this->hasMany(Bid::class, 'item_id', 'id');
    }

    public static function canBid($id)
    {
        return self::where(['id' => $id])->whereDate('finished_at', '>=', date('Y-m-d H:i:s'))->first();
    }

    public function updateFinalPrice($amount)
    {
        $this->final_price += $amount;
    }
}
