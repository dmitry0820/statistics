<?php
namespace app\models\data_provider;


use app\models\sql\SqlSelections;
use yii\base\Model;
use yii\data\SqlDataProvider;

class SelectionsProviderBuilder extends Model
{

    public $smi;
    public $city;
    public $site;

    private $data_provider;

    public function rules()
    {
        return [
            [[
                'smi',
                'city',
                'site',
            ], 'string'],
            [[
                'smi',
                'city',
                'site',
            ], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @return $this
     */
    public function build()
    {
        $sql_builder = new SqlSelections();
        $sql = $sql_builder
            ->build()
            ->getSql();

        $count = $sql_builder
            ->count();

        $this->data_provider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this;
    }

    /**
     * @return SqlDataProvider
     */
    public function getDataProvider()
    {
        return $this->data_provider;
    }
}