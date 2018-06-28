<?php
namespace app\models;


use yii\base\Model;
use app\models\sql\SqlStatistics;

class StatisticsBuilder extends Model
{

    public $vm_id;
    public $avg_stake_size;

    public $coefficient_type;
    public $coefficient_value;

    public $bet_type;
    public $bet_result;

    public $added_at_from;
    public $added_at_to;

    public $real_cf_type;
    public $real_cf_value;

    private $result;
    private $sql;

    /**
     * @return mixed
     */
    public function getSql()
    {
        return $this->sql;
    }

    public function rules()
    {
        return [
            [[
                'vm_id',
                'avg_stake_size',

                'coefficient_type',
                'coefficient_value',

                'bet_type',
                'bet_result',

                'added_at_from',
                'added_at_to',

                'real_cf_type',
                'real_cf_value',
            ], 'string'],
        ];
    }

    /**
     * @return $this
     */
    public function build()
    {

        $sql = new SqlStatistics();
        $this->result = $sql
            ->setVmId($this->vm_id)
            ->setCoefficientType($this->coefficient_type)
            ->setCoefficientValue($this->coefficient_value)
            ->setRealCfType($this->real_cf_type)
            ->setRealCfValue($this->real_cf_value)
            ->setBetType($this->bet_type)
            ->setBetResult($this->bet_result)
            ->setAddedAtFrom($this->added_at_from)
            ->setAddedAtTo($this->added_at_to)
            ->build()
            ->one();

        $this->sql = $sql->getSql();

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }
}