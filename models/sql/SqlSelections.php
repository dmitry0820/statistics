<?php
namespace app\models\sql;


use app\models\entity\BetResult;
use app\models\entity\BetType;
use app\models\entity\Comparison;

class SqlSelections extends SqlAbstract
{

    public function build()
    {
        $this->command
            ->select($this->getFields())
            ->from('selections')
            ->orderBy('created_at desc');

        return $this;
    }
}