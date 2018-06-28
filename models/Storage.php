<?php
namespace app\models;


use app\models\ar\ArSelection;

class Storage
{

    private $statistics;

    public function __construct(Statistics $statistics)
    {
        $this->statistics = $statistics;
    }

    public function save()
    {
        $ar = new ArSelection();
        $ar->avg_stake_size = $this->statistics->getAvgStakeSize();
        $ar->count_all = $this->statistics->getCountAll();
        $ar->count_win = $this->statistics->getCountWin();
        $ar->count_lose = $this->statistics->getCountLose();
        $ar->avg_win = $this->statistics->getAvgWin();
        $ar->avg_lose = $this->statistics->getAvgLose();
        $ar->percent_win = $this->statistics->getPercentWin();
        $ar->percent_lose = $this->statistics->getPercentLose();
        $ar->total_win = $this->statistics->getTotalWin();
        $ar->total_lose = $this->statistics->getTotalLose();
        $ar->total_income = $this->statistics->getTotalIncome();
        $ar->avg_income = $this->statistics->getAvgIncome();
        $ar->roi = $this->statistics->getRoi();
        $ar->ratio = $this->statistics->getRatio();
        $ar->save();
    }
}