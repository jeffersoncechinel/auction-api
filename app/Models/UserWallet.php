<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserWallet
 * @package App\Models
 * @property integer $maximum_amount
 */
class UserWallet extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'user_id';
    protected $fillable = ['maximum_amount', 'amount_remaining'];
}
