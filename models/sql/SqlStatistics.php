<?php
namespace app\models\sql;


use app\models\entity\BetResult;
use app\models\entity\BetType;
use app\models\entity\Comparison;

class SqlStatistics extends SqlAbstract
{
    const DEFAULT_AVG_STAKE_SIZE = 100;

    // TODO fork_income (числовое значение, от 0 и выше)

    private $vm_id;
    private $avg_stake_size;

    private $coefficient_type;
    private $coefficient_value;
    private $bet_type;
    private $bet_result;
    private $added_at_from;
    private $added_at_to;
    private $real_cf_value;
    private $real_cf_type;


    protected function getFields()
    {
        return [
            //'*',
            'COUNT(*) as count_all',
            'SUM(IF(bet_result = 1, 1, 0)) as count_win',
            'SUM(IF(bet_result = -1, 1, 0)) as count_lose',

            'SUM(IF(bet_result = 1, real_cf * '. $this->getAvgStakeSize() .' - '. $this->getAvgStakeSize() .', 0)) as total_win',
            'SUM(IF(bet_result = -1, '. $this->getAvgStakeSize() .', 0)) as total_lose',

            'COUNT(*) * '. $this->getAvgStakeSize() .' as total_size',
        ];
    }

    public function build()
    {
        $this->command
            ->select($this->getFields())
            ->from('forks_stakes');

        $this->createWhere();

        return $this;
    }

    private function createWhere()
    {
        if ($this->vm_id) {
            $this->command
                ->andWhere(['vm_id' => $this->vm_id,]);
        }

        if ($this->coefficient_value) {
            $this->command
                ->andWhere([
                    Comparison::getSqlSign($this->coefficient_type),
                    'fork_income',
                    $this->coefficient_value
                ]);
        }

        if ($this->real_cf_value) {
            $this->command
                ->andWhere([
                    Comparison::getSqlSign($this->real_cf_type),
                    'real_cf',
                    $this->real_cf_value
                ]);
        }

        if (!in_array($this->bet_type, [null, BetType::ALL])) {
            $this->command
                ->andWhere('bet_name like "' . BetType::getSqlBetType($this->bet_type) .'"');
        }

        if (in_array($this->bet_result, [BetResult::WIN, BetResult::LOSE])) {
            $this->command
                ->andWhere([
                    'bet_result' => $this->bet_result
                ]);
        }

        if ($this->added_at_from) {
            $this->command
                ->andWhere([
                    '>=',
                    'added_at',
                    $this->added_at_from
                ]);
        }

        if ($this->added_at_to) {
            $this->command
                ->andWhere([
                    '<=',
                    'added_at',
                    $this->added_at_to
                ]);
        }

    }

    private function getAvgStakeSize()
    {
        return $this->avg_stake_size ?: static::DEFAULT_AVG_STAKE_SIZE;
    }

    /**
     * @param mixed $avg_stake_size
     * @return $this
     */
    public function setAvgStakeSize($avg_stake_size)
    {
        $this->avg_stake_size = $avg_stake_size;
        return $this;
    }

    /**
     * @param mixed $vm_id
     * @return $this
     */
    public function setVmId($vm_id)
    {
        $this->vm_id = $vm_id;
        return $this;
    }

    /**
     * @param mixed $date_from
     * @return $this
     */
    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;
        return $this;
    }

    /**
     * @param mixed $coefficient_type
     * @return $this
     */
    public function setCoefficientType($coefficient_type)
    {
        $this->coefficient_type = $coefficient_type;
        return $this;
    }

    /**
     * @param mixed $coefficient_value
     * @return $this
     */
    public function setCoefficientValue($coefficient_value)
    {
        $this->coefficient_value = $coefficient_value;
        return $this;
    }

    /**
     * @param mixed $bet_type
     * @return $this
     */
    public function setBetType($bet_type)
    {
        $this->bet_type = $bet_type;
        return $this;
    }

    /**
     * @param mixed $bet_result
     * @return $this
     */
    public function setBetResult($bet_result)
    {
        $this->bet_result = $bet_result;
        return $this;
    }

    /**
     * @param mixed $added_at_from
     * @return $this
     */
    public function setAddedAtFrom($added_at_from)
    {
        $this->added_at_from = $added_at_from;
        return $this;
    }

    /**
     * @param mixed $added_at_to
     * @return $this
     */
    public function setAddedAtTo($added_at_to)
    {
        $this->added_at_to = $added_at_to;
        return $this;
    }

    /**
     * @param mixed $real_cf_value
     * @return $this
     */
    public function setRealCfValue($real_cf_value)
    {
        $this->real_cf_value = $real_cf_value;
        return $this;
    }

    /**
     * @param mixed $real_cf_type
     * @return $this
     */
    public function setRealCfType($real_cf_type)
    {
        $this->real_cf_type = $real_cf_type;
        return $this;
    }
}