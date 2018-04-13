<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DrupalUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drupal-users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'columns' => [
                'username',

//            ['class' => 'yii\grid\SerialColumn'],

//            'uid',
//            'name',
//            'pass',
//            'mail',
//            [
//                'attribute' =>  'userBalance.balance',
//                'value' => function($data){
//                        return !empty($data->userBalance->balance) ? $data->userBalance->balance : '0.00';
//                }
//            ],

//            'theme',
            // 'signature',
            // 'signature_format',
            // 'created',
            // 'access',
            // 'login',
            // 'status',
            // 'timezone',
            // 'language',
            // 'picture',
            // 'init',
            // 'data',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return  Html::a('Пополнить', $url)." | ".Html::a('История', $url);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
