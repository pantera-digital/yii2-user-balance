<?php

namespace pantera\user\balance\controllers;

use pantera\user\balance\models\UsersBalanceHistory;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->access,
                    ],
                ]
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => (Yii::$app->userBalance->userModel)::find(),
            ]),
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $balanceHistory = new UsersBalanceHistory([
            'user_id' => $id,
            'status' => UsersBalanceHistory::STATUS_CONFIRMED,
        ]);

        if ($balanceHistory->load(Yii::$app->request->post()) && $balanceHistory->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        $balanceHistoryProvider = new ActiveDataProvider([
            'query' => UsersBalanceHistory::find()->where(['user_id' => $id])->orderBy('created_at DESC'),
            'sort' => false,
        ]);

        return $this->render('view', [
            'user' => $this->findModel($id),
            'balanceHistory' => $balanceHistory,
            'balanceHistoryProvider' => $balanceHistoryProvider,
        ]);
    }

    /**
     * Finds the DrupalUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DrupalUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = (Yii::$app->userBalance->userModel)::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
