<?php

namespace App\Properties;

class Years
{
    public static function getYears(): array
    {
        // return years from 1999 to current year
        return range(1999, date('Y'));
    }
}
