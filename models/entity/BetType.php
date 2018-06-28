<?php
namespace app\models\entity;


class BetType
{
    const ALL = 'ALL';

    const WIN = 'WIN';
    const GAME_WIN = 'GAME_WIN';
    const SET_WIN = 'SET_WIN';

    const TOTALS = 'TOTALS';
    const SET_TOTALS = 'SET_TOTALS';

    const HANDICAP = 'HANDICAP';
    const SET_HANDICAP = 'SET_HANDICAP';

    public static function getAll()
    {
        return [
            static::ALL,
            static::WIN,
            static::GAME_WIN,
            static::SET_WIN,
            static::TOTALS,
            static::SET_TOTALS,
            static::HANDICAP,
            static::SET_HANDICAP,
        ];
    }

    public static function getSelectItems()
    {
        return [
            static::ALL => 'Все',
            static::WIN => static::WIN,
            static::GAME_WIN => static::GAME_WIN,
            static::SET_WIN => static::SET_WIN,
            static::TOTALS => static::TOTALS,
            static::SET_TOTALS => static::SET_TOTALS,
            static::HANDICAP => static::HANDICAP,
            static::SET_HANDICAP => static::SET_HANDICAP,
        ];
    }

    public static function getSqlBetType($name)
    {
        $sql_bet_types = [
            static::WIN => 'WIN\_\_%',
            static::GAME_WIN => 'GAME\_\_%',
            static::SET_WIN => 'SET\_%\_\_WIN\_\_%',
            static::TOTALS => 'TOTALS\_\_%',
            static::SET_TOTALS => 'SET\_%\_\_TOTALS\_\_',
            static::HANDICAP => 'HANDICAP\_\_%',
            static::SET_HANDICAP => 'SET\_%\_\_HANDICAP',
        ];

        return $sql_bet_types[$name];
    }
}