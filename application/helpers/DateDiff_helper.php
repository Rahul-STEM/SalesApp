<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_diff_format'))
{
    /**
     * Calculate the difference between two dates and return in "days hours min" format.
     *
     * @param string $date1 The first date (in 'Y-m-d H:i:s' format)
     * @param string $date2 The second date (in 'Y-m-d H:i:s' format)
     * @return string The difference in "days hours min" format
     */
    function date_diff_format($date1, $date2)
    {
        // Create DateTime objects from the input strings
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);

        // Calculate the difference
        $interval = $datetime1->diff($datetime2);

        // Build the formatted difference string
        // $result = '';

        // if ($interval->days > 0) {
        //     $result .= $interval->days . ' days ';
        // }
        // if ($interval->h > 0) {
        //     $result .= $interval->h . ' hours ';
        // }
        // if ($interval->i > 0) {
        //     $result .= $interval->i . ' mins';
        // }

        return trim($interval);
    }
}
