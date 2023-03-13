<?php

namespace App\Properties;

class Years
{
    public static function getYears(): array
    {
        // return years from 1999 to current year, reverse order
        return array_reverse(range(1999, date('Y')));
    }
}
