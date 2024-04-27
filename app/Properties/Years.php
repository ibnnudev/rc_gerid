<?php

namespace App\Properties;

use Carbon\Carbon;

class Years
{
    public static function getYears(): array
    {
        // return years from 1999 to current year, reverse order
        return array_reverse(range(1945, date('Y')));
    }

    // 10 years ago
    public static function getTenYearsAgo()
    {
        return array_reverse(range(date('Y'), date('Y') - 10));
    }
}
