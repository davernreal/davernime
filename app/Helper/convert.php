<?php

namespace App\Helper;

class Convert
{
    public static function convertToTime($data)
    {
        try {
            $totalMinutes = 0;
            $totalSeconds = 0;

            foreach ($data as $item) {
                if (in_array(strtolower($item), ['unknown', 'not available', ''])) {
                    return null;
                }

                $item = str_replace([' per ep'], '', $item);

                if (strpos($item, 'hr') !== false) {
                    preg_match('/(\d+)\s*hr\s*(\d+)\s*min/', $item, $matches);
                    if ($matches) {
                        $totalMinutes += ($matches[1] * 60) + $matches[2];
                    } else {
                        preg_match('/(\d+)\s*hr/', $item, $matches);
                        $totalMinutes += ($matches[1] * 60);
                    }
                } else {
                    preg_match('/(\d+)\s*min/', $item, $matches);
                    if ($matches) {
                        $totalMinutes += $matches[1];
                    }

                    preg_match('/(\d+)\s*sec/', $item, $secMatches);
                    if ($secMatches) {
                        $totalSeconds += $secMatches[1];
                    }
                }
            }

            $totalMinutes += floor($totalSeconds / 60);
            $totalSeconds = $totalSeconds % 60;

            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;

            // Return the time formatted as 'HH:MM:SS'
        } catch (\Throwable $th) {
            print_r($data);
            throw $th;
        }
    }
}
