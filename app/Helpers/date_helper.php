<?php

if (!function_exists('format_date')) {
    function format_date($date_string, $format = 'full')
    {
        if (empty($date_string) || $date_string === '0000-00-00 00:00:00') {
            return '-';
        }

        try {
            $date = new DateTime($date_string);
            $day = $date->format('d');
            $month = (int)$date->format('n');
            $year = $date->format('Y');
            $hour = $date->format('H');
            $minute = $date->format('i');

            $months = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];

            // Short month names in Indonesian (used when $format is 'short' or 'short_date_only')
            $shortMonths = [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'Mei',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Agu',
                9 => 'Sep',
                10 => 'Okt',
                11 => 'Nov',
                12 => 'Des',
            ];

            // Choose month set based on requested format
            if (in_array($format, ['short', 'short_date_only'], true)) {
                $monthNames = $shortMonths;
            } else {
                $monthNames = $months;
            }

            // date_only / short_date_only: omit time
            if ($format === 'date_only' || $format === 'short_date_only') {
                return $day . ' ' . $monthNames[$month] . ' ' . $year;
            }

            if ($format === 'month_year') {
                return $monthNames[$month] . ' ' . $year;
            }

            // default (full) or short: include time
            return $day . ' ' . $monthNames[$month] . ' ' . $year . ', ' . $hour . ':' . $minute;
        } catch (Exception $e) {
            return '-';
        }
    }
}
