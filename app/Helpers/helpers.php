<?php

if (! function_exists('timeAgo')) {
    function timeAgo($datetime): string
    {
        if (empty($datetime)) {
            return '-';
        }
        $time = strtotime((string) $datetime);
        if (! $time) {
            return '-';
        }
        $diff = time() - $time;

        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . ' menit lalu';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . ' jam lalu';
        } elseif ($diff < 2592000) {
            return floor($diff / 86400) . ' hari lalu';
        }

        return date('d M Y', $time);
    }
}

if (! function_exists('getInitial')) {
    function getInitial($nama): string
    {
        $words = explode(' ', trim((string) $nama));
        $initial = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initial .= mb_strtoupper(mb_substr($w, 0, 1));
        }

        return $initial ?: 'U';
    }
}
