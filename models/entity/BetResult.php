<?php
namespace app\models\entity;


class BetResult
{

    const ALL = 'ALL';

    const WIN = 1;
    const LOSE = -1;

    public static function getAll()
    {
        return [
            static::ALL,
            static::WIN,
            static::LOSE,
        ];
    }

    public static function getSelectItems()
    {
        return [
            static::ALL => 'Все',
            static::WIN => 'Выиграли',
            static::LOSE => 'Проиграли',
        ];
    }
}