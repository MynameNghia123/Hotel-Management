<?php

namespace App\Helpers;

class TimeHelper
{
    /**
     * Format hour_mark decimal to time string
     * Example: 1.0 => "1h", 1.5 => "1h30p", 3.25 => "3h15p"
     */
    public static function formatHourMark($hourMark)
    {
        if ($hourMark === null) {
            return '0h';
        }

        $hours = (int) $hourMark;
        $minutes = ($hourMark - $hours) * 60;

        if ($minutes == 0) {
            return $hours.'h';
        }

        return $hours.'h'.(int) $minutes.'p';
    }

    /**
     * Parse time string to hour_mark decimal
     * Example: "1h" => 1.0, "1h30p" => 1.5, "3h15p" => 3.25
     */
    public static function parseHourMark($timeString)
    {
        if (empty($timeString)) {
            return 0;
        }

        // Match pattern: 1h30p or 1h or 0h45p etc
        if (preg_match('/^(\d+)h(?:(\d+)p)?$/', trim($timeString), $matches)) {
            $hours = (int) $matches[1];
            $minutes = isset($matches[2]) ? (int) $matches[2] : 0;

            return $hours + ($minutes / 60);
        }

        return 0;
    }
}
