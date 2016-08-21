<?php

namespace Game;


class View
{
    public static $output = '';

    public static function add($message) {
        self::$output .= $message;
    }

    public static function output()
    {
       echo self::$output;
    }
}