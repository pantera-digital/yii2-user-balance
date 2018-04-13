<?php

namespace pantera\user\balance\controllers;

use pantera\user\balance\models\UsersBalance;
use pantera\user\balance\models\UsersBalanceHistory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DrupalUsersController implements the CRUD actions for DrupalUsers model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Lists all DrupalUsers models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->renderContent('В разработке');
        $searchModel = new DrupalUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DrupalUsers model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if($id != 0) {
            $userBalanceModel = UsersBalance::findOne(['user_id' => $id]);
            if(empty($userBalanceModel)) {
                $userBalanceModel = new UsersBalance();
                $userBalanceModel->user_id = $id;
                $userBalanceModel->balance = 0;
                $userBalanceModel->income_money = 0;

                $userBalanceModel->save();
            }
        } else {
            throw new NotFoundHttpException();
        }
        $incoming = Yii::$app->request->post('UsersBalance')['income_money'];
        $comment = Yii::$app->request->post('UsersBalance')['comment'];

        if(empty($userBalanceModel)){
            $userBalanceModel =  new UsersBalance();
        }
        if(Yii::$app->request->isPost){
            $userBalanceModel->load(Yii::$app->request->post());
            if($userBalanceModel->income($incoming)->save()) {
                $userBalanceHistory = new UsersBalanceHistory();
                $userBalanceHistory->user_id = $id;
                $userBalanceHistory->comment = $comment;
                $userBalanceHistory->sum = $incoming;
                if($userBalanceHistory->save()) {
                    return $this->redirect(['view','id' => $id]);
                }
            }
        }
        $userBalanceModel = UsersBalance::findOne($id);
        $balanceHistoryProvider = new ActiveDataProvider([
                'query' => UsersBalanceHistory::find()->where(['user_id' => $id])->orderBy('created_at DESC'),
                'sort' => false,
        ]);
        return $this->render('view', [
                'model' => $this->findModel($id),
                'historyProvider' => $balanceHistoryProvider,
                'balanceModel' => $userBalanceModel,
        ]);


    }

    public function actionBalanceUpdate($id){
        return '';
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
