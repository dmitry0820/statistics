<?php

/* @var $this yii\web\View */
/* @var $statistics Statistics[] */

use app\models\entity\Comparison;
use app\models\Statistics;
use app\models\entity\BetType;
use dosamigos\highcharts\HighCharts;
use kartik\date\DatePicker;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Статистика';
$request = Yii::$app->getRequest();
?>

<div class="row">
    <div class="col-sm-12">
        <?php

        echo Nav::widget([
            'items' => [
                [
                    'label' => 'Статистика',
                    'active' => true,
                ],
            ],
            'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
            'activateParents' => true,
        ]);
        ?>
    </div>
</div>

<h1 style="margin-bottom: 40px"><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-sm-9">

        <?php
            echo HighCharts::widget([
            'clientOptions' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'categories' => [
                        'ROI',
                        'PROFIT RATIO',
                    ]
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Значение'
                    ]
                ],
                'series' => [
                    ['name' => BetType::ALL, 'data' => [
                        $statistics[BetType::ALL]->getRoi(),
                        $statistics[BetType::ALL]->getRatio()
                    ]],
                    ['name' => BetType::WIN, 'data' => [
                        $statistics[BetType::WIN]->getRoi(),
                        $statistics[BetType::WIN]->getRatio()
                    ]],
                    ['name' => BetType::GAME_WIN, 'data' => [
                        $statistics[BetType::GAME_WIN]->getRoi(),
                        $statistics[BetType::GAME_WIN]->getRatio()
                    ]],
                    ['name' => BetType::SET_WIN, 'data' => [
                        $statistics[BetType::SET_WIN]->getRoi(),
                        $statistics[BetType::SET_WIN]->getRatio()
                    ]],
                    ['name' => BetType::TOTALS, 'data' => [
                        $statistics[BetType::TOTALS]->getRoi(),
                        $statistics[BetType::TOTALS]->getRatio()
                    ]],
                    ['name' => BetType::SET_TOTALS, 'data' => [
                        $statistics[BetType::SET_TOTALS]->getRoi(),
                        $statistics[BetType::SET_TOTALS]->getRatio()
                    ]],
                    ['name' => BetType::HANDICAP, 'data' => [
                        $statistics[BetType::HANDICAP]->getRoi(),
                        $statistics[BetType::HANDICAP]->getRatio()
                    ]],
                    ['name' => BetType::SET_HANDICAP, 'data' => [
                        $statistics[BetType::SET_HANDICAP]->getRoi(),
                        $statistics[BetType::SET_HANDICAP]->getRatio()
                    ]],
                ]
            ]
        ]);
        ?>
    </div>

    <div class="col-sm-3">
        <?php
        $form = ActiveForm::begin([
            'id' => 'filter-form',
            'method' => 'get',
            'action' => Url::to(['site/index']),
        ]);
        ?>

        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12">
                <label class="control-label">Даты</label>
                <?php
                echo DatePicker::widget([
                    'model' => $model,
                    'type' => DatePicker::TYPE_RANGE,
                    'attribute' => 'added_at_from',
                    'attribute2' => 'added_at_to',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ],
                    'language' => 'ru',
                ]);
                ?>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Коэффициент (fork_income)</label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <?= Html::activeDropDownList($model, 'coefficient_type', [
                                Comparison::EQUAL => Comparison::getSqlSign(Comparison::EQUAL),
                                Comparison::GT => Comparison::getSqlSign(Comparison::GT),
                                Comparison::LT => Comparison::getSqlSign(Comparison::LT),
                            ], ['class'=>'input-group-selected btn btn-default dropdown-toggle'] ) ?>
                        </div>
                        <?= Html::activeTextInput($model, 'coefficient_value', ['class'=>'form-control']) ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Коэффициент (real_cf)</label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <?= Html::activeDropDownList($model, 'real_cf_type', [
                                Comparison::EQUAL => Comparison::getSqlSign(Comparison::EQUAL),
                                Comparison::GT => Comparison::getSqlSign(Comparison::GT),
                                Comparison::LT => Comparison::getSqlSign(Comparison::LT),
                            ], ['class'=>'input-group-selected btn btn-default dropdown-toggle'] ) ?>
                        </div>
                        <?= Html::activeTextInput($model, 'real_cf_value', ['class'=>'form-control']) ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <input type="submit" name="filters_btn" value=Применить class="btn btn-primary" style="float: right">
            </div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>

<div class="well"><small>Пример запроса в БД:</small> <br><?= $sql ?></div>