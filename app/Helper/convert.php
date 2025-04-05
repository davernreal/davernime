<?php

namespace App\Helper;

class Convert
{
    public static function convertToTime($data)
    {
        try {
            $totalMinutes = 0;
            $totalSeconds = 0;

            // Handle cases like 'Unknown' or 'Not available'
            foreach ($data as $item) {
                // Skip invalid or unknown time values
                if (in_array(strtolower($item), ['unknown', 'not available', ''])) {
                    return null; // Return null or you can handle differently if needed
                }

                // Remove 'per ep' or similar suffix
                $item = str_replace([' per ep'], '', $item);

                // Parse hours and minutes
                if (strpos($item, 'hr') !== false) {
                    preg_match('/(\d+)\s*hr\s*(\d+)\s*min/', $item, $matches);
                    if ($matches) {
                        // If both hours and minutes are present
                        $totalMinutes += ($matches[1] * 60) + $matches[2];
                    } else {
                        preg_match('/(\d+)\s*hr/', $item, $matches);
                        // If only hours are present
                        $totalMinutes += ($matches[1] * 60);
                    }
                } else {
                    // Parse minutes
                    preg_match('/(\d+)\s*min/', $item, $matches);
                    if ($matches) {
                        $totalMinutes += $matches[1];
                    }

                    // Parse seconds and convert to minutes
                    preg_match('/(\d+)\s*sec/', $item, $secMatches);
                    if ($secMatches) {
                        $totalSeconds += $secMatches[1];
                    }
                }
            }

            // Convert total seconds into minutes and remaining seconds
            $totalMinutes += floor($totalSeconds / 60);
            $totalSeconds = $totalSeconds % 60;

            // Convert total minutes into hours, minutes, and seconds
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;

            // Return the time formatted as 'HH:MM:SS'
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $totalSeconds);
        } catch (\Throwable $th) {
            print_r($data);
            throw $th;
        }
    }
}
