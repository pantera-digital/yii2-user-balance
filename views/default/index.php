<?php

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
        'columns' => [
            'username',
            [
                'header' => 'Баланс',
                'value' => function (ActiveRecord $model) {
                    return Yii::$app->userBalance->getBalance($model);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('Пополнить', $url) . " | " . Html::a('История', $url);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
