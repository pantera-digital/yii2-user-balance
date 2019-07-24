<?php

use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model ActiveRecord */
$this->title = $model->getPrimaryKey();
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drupal-users-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Информация о пользователе</strong>
                </div>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => array_merge($model->attributes(), [[
                        'label' => 'Баланс',
                        'value' => Yii::$app->userBalance->getBalance($model),
                    ]]),
                ]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Изменить баланс</strong>
                </div>
                <div class="panel-body">

                    <?php $form =  \yii\widgets\ActiveForm::begin()?>
                        <?= $form->field($balanceModel, 'income_money')->textInput() ?>
                        <?= $form->field($balanceModel, 'comment')->textInput() ?>
                        <?= Html::submitButton('Изменить баланс',['class' => 'btn btn-primary btn-block'])?>
                    <?php \yii\widgets\ActiveForm::end()?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>История пополнений</strong>
                </div>
                <div class="panel-body">
                    <?= \yii\grid\GridView::widget([
                        'summary' => false,
                        'tableOptions' => [
                            'class' => 'table table-stripped',
                        ] ,
                        'dataProvider' => $historyProvider,
//        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                    'attribute' => 'created_at',
                                    'value' => function($data) {
                                        return Yii::$app->formatter->asDatetime($data->created_at,'long');
                                    }
                            ],
                            'sum',
                            'comment:ntext',
                        ],
                    ]); ?>
                </div>
            </div>

        </div>
    </div>


</div>
