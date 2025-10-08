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

            if ($format === 'date_only') {
                return $day . ' ' . $months[$month] . ' ' . $year;
            }

            return $day . ' ' . $months[$month] . ' ' . $year . ', ' . $hour . ':' . $minute;
        } catch (Exception $e) {
            return '-';
        }
    }
}
