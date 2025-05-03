<?php

namespace App\Helper;

class Season
{
    public static function getSeason()
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $seasons = [
            'winter' => [1, 2, 3],
            'spring' => [4, 5, 6],
            'summer' => [7, 8, 9],
            'fall'   => [10, 11, 12],
        ];

        foreach ($seasons as $season => $months) {
            if (in_array($currentMonth, $months)) {
                return [
                    'season' => $season,
                    'year' => $currentYear,
                ];
            }
        }
    }
}