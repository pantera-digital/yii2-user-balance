<?php

use pantera\user\balance\models\UsersBalanceHistory;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drupal-users-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'columns' => [
            'username:text:Пользователь',
            [
                'header' => 'В обработке',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center warning'],
                'value' => function (ActiveRecord $model) {
                    return Yii::$app->userBalance->getBalance($model, UsersBalanceHistory::STATUS_INITIAL, UsersBalanceHistory::OPERATION_TYPE_INCREASE);
                },
            ],
            [
                'header' => 'Поступило',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center success'],
                'value' => function (ActiveRecord $model) {
                    return Yii::$app->userBalance->getBalance($model, UsersBalanceHistory::STATUS_CONFIRMED, UsersBalanceHistory::OPERATION_TYPE_INCREASE);
                },
            ],
            [
                'header' => 'Запрошено',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center warning'],
                'value' => function (ActiveRecord $model) {
                    return Yii::$app->userBalance->getBalance($model, UsersBalanceHistory::STATUS_INITIAL, UsersBalanceHistory::OPERATION_TYPE_DECREASE);
                },
            ],
            [
                'header' => 'Выплачено',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center success'],
                'value' => function (ActiveRecord $model) {
                    return Yii::$app->userBalance->getBalance($model, UsersBalanceHistory::STATUS_CONFIRMED, UsersBalanceHistory::OPERATION_TYPE_DECREASE);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('Подробнее', $url);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
