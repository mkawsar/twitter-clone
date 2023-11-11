<?php

if (!function_exists('getTimeAgo')) {
    function getTimeAgo($time)
    {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w'],
            $time->diffForHumans()
        );
    }
}
