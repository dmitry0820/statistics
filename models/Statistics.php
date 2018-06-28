<?php
namespace app\models;


class Statistics
{

    private $sql_result;

    public function __construct(array $sql)
    {
        $this->sql_result = $sql;
    }

    // TODO take it from user interface
    public function getAvgStakeSize()
    {
        return 100;
    }

    public function getCountAll()
    {
        return $this->sql_result['count_all'];
    }

    public function getCountWin()
    {
        return $this->sql_result['count_win'];
    }

    public function getCountLose()
    {
        return $this->sql_result['count_lose'];
    }

    public function getTotalWin()
    {
        return $this->sql_result['total_win'];
    }

    public function getTotalLose()
    {
        return $this->sql_result['total_lose'];
    }

    public function getTotalIncome()
    {
        return $this->sql_result['total_win'] - $this->sql_result['total_lose'];
    }

    public function getPercentWin()
    {
        return $this->sql_result['count_all'] ? 100 * $this->sql_result['count_win'] / $this->sql_result['count_all'] : 0;
    }

    public function getPercentLose()
    {
        return $this->sql_result['count_all'] ? 100 * $this->sql_result['count_lose'] / $this->sql_result['count_all'] : 0;
    }

    public function getAvgWin()
    {
        return $this->getCountWin() ? ($this->getTotalWin() / $this->getCountWin()) : 0;
    }

    public function getAvgLose()
    {
        return $this->getCountLose() ? ($this->getTotalLose() / $this->getCountLose()) : 0;
    }

    public function getAvgIncome()
    {
        return $this->getCountAll() ? $this->getTotalIncome() / $this->getCountAll() : 0;
    }

    public function getRoi()
    {
        return $this->getAvgSize() ? (100 * $this->getAvgIncome() / $this->getAvgSize()) : 0;
    }

    public function getRatio()
    {
        return $this->getPercentLose() * $this->getAvgLose() ?
            abs(
                ($this->getPercentWin() / $this->getPercentLose())
                    * ($this->getAvgWin() / $this->getAvgLose())
            )
            : 0;
    }

    private function getAvgSize()
    {
        return $this->getCountAll() ? $this->sql_result['total_size'] / $this->getCountAll() : 0;
    }
}