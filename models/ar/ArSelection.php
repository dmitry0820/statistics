<?php
namespace app\models\ar;


use yii\db\ActiveRecord;

/**
 * @property integer id
 * @property float avg_stake_size
 * @property integer count_all
 * @property integer count_win
 * @property integer count_lose
 * @property float avg_win
 * @property float avg_lose
 * @property float percent_win
 * @property float percent_lose
 * @property float total_win
 * @property float total_lose
 * @property float total_income
 * @property float avg_income
 * @property float roi
 * @property float ratio
 * @property string created_at
 */
class ArSelection extends ActiveRecord
{
    public static function tableName()
    {
        return 'selections';
    }
}