<?php
namespace app\models\helper;


class Format
{

    public static function money($value)
    {
        return number_format($value, 2, ',', ' ');
    }
}