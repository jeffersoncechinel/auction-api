<?php

namespace App\Common\Helpers;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class DateTimeHelper
{

    public static function datetimeFromUTC($datetime, $timezone = 'America/New_York')
    {
        $date = new DateTime($datetime, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone($timezone));

        return $date->format('Y-m-d H:i:s');
    }

    public static function now()
    {
        return gmdate('Y-m-d H:i:s');
    }
}
