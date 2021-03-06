<?php

namespace App\Common\Helpers;

use DateTime;
use DateTimeZone;

class DateTimeHelper
{
    public static function datetimeFromUTC($datetime, $timezone = 'America/Sao_Paulo')
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
