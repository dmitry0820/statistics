<?php
namespace app\models\entity;


class Comparison
{

    const EQUAL = 'equal';
    const LT = 'lt';
    const GT = 'gt';

    public static function getSqlSign($name)
    {
        $sql_signs = [
            static::EQUAL => '=',
            static::LT => '<',
            static::GT => '>',
        ];

        return $sql_signs[$name];
    }
}