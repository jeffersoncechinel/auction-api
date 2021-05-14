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
    protected $fillable = ['maximum_amount'];

    /**
     * @param int $value
     * @return bool
     */
    public function decrementAmount(int $value = 1)
    {
        if ($this->maximum_amount <= 0 || $this->maximum_amount < $value) {
            return false;
        }

        $this->maximum_amount -= $value;

        return true;
    }

    /**
     * @param int $value
     * @return bool
     */
    public function incrementAmount(int $value = 1)
    {
        $this->maximum_amount += $value;

        return true;
    }
}
