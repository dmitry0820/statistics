<?php
namespace app\controllers;


use Yii;
use yii\web\Controller;
use app\models\Formula;
use app\models\Statistics;
use app\models\entity\BetType;
use app\models\StatisticsBuilder;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $request = Yii::$app->request;

        $statistics_builder = new StatisticsBuilder();
        $statistics_builder->load($request->queryParams);

        if ($statistics_builder->validate()) {

            $statistics = $this->createStatistics($statistics_builder);

            return $this->render('statistics', [
                'statistics' => $statistics,
                'model' => $statistics_builder,
                'sql' => $statistics_builder->getSql(),

            ]);
        }

        $session = Yii::$app->getSession();
        $session->setFlash('error', $statistics_builder->getErrors());
        return '';
    }

    public function actionStatistics()
    {
        Formula::test();
    }

    private function createStatistics(StatisticsBuilder $statistics_builder)
    {
        $stats = [];
        foreach (BetType::getAll() as $bet_type) {
            $statistics_builder->bet_type = $bet_type;
            $statistics_builder->build();
            $stats[$bet_type] = new Statistics($statistics_builder->getResult());
        }

        return $stats;
    }
}
