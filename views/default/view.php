<?php

use pantera\user\balance\models\UsersBalanceHistory;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = $user->getPrimaryKey();
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* @var $this View */
/* @var $user ActiveRecord */
?><div class="user-balance-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Информация о пользователе</strong>
                </div>
                <?= DetailView::widget([
                    'model' => $user,
                    'attributes' => array_merge($user->attributes(), [[
                        'label' => 'Баланс',
                        'value' => Yii::$app->userBalance->getBalance($user),
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
                    <?php $form = ActiveForm::begin()?>
                        <?= $form->field($balanceHistory, 'sum')->textInput() ?>
                        <?= $form->field($balanceHistory, 'comment')->textInput() ?>
                        <?= Html::submitButton('Изменить баланс', ['class' => 'btn btn-primary btn-block'])?>
                    <?php ActiveForm::end()?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>История пополнений</strong>
                </div>
                <div class="panel-body">
                    <?= GridView::widget([
                        'summary' => false,
                        'tableOptions' => [
                            'class' => 'table table-stripped',
                        ] ,
                        'dataProvider' => $balanceHistoryProvider,
                        'rowOptions' => function($model){
                            $classes = [
                                UsersBalanceHistory::STATUS_INITIAL => 'warning',
                                UsersBalanceHistory::STATUS_CONFIRMED => 'success',
                                UsersBalanceHistory::STATUS_DECLINED => 'danger',
                            ];
                            return ['class' => $classes[$model->status]];
                        },
                        'columns' => [
                            'created_at:datetime',
                            'sum',
                            'statusName:text:Статус',
                            'comment:ntext',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
