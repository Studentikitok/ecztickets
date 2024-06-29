<?php

namespace app\controllers;

use app\models\Poster;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use app\models\Order;

/**
 * PosterController implements the CRUD actions for Poster model.
 */
class PosterController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Poster models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Poster::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id_poster' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Poster model.
     * @param int $id_poster Id Poster
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_poster)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_poster),
        ]);
    }

    /**
     * Creates a new Poster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Poster();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_poster' => $model->id_poster]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionOrder()
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->redirect(['site/login']);
        }

        if(Yii::$app->request->post())
        {
            $poster = Poster::findOne($this->request->post() ['id_poster']);
            if ($poster->tickets<$this->request->post() ['tickets']){
                Yii::$app->session->setFlash('danger', 'Невозможно заказать билеты');
                return $this->redirect(['view', 'id_poster' => $poster->id_poster]);
            }

            $poster->tickets = $poster->tickets - $this->request->post() ['tickets'];
            $poster->save();
            $model = new Order();
            $model -> username = Yii::$app->user->identity->username;
            $model -> id_poster = $this->request->post() ['id_poster'];
            $model -> tickets = $this->request->post() ['tickets'];
            $model -> save();
            Yii::$app->session->setFlash('success', 'Билеты заказаны');
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Poster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_poster Id Poster
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_poster)
    {
        $model = $this->findModel($id_poster);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_poster' => $model->id_poster]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Poster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_poster Id Poster
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_poster)
    {
        $this->findModel($id_poster)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Poster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_poster Id Poster
     * @return Poster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_poster)
    {
        if (($model = Poster::findOne(['id_poster' => $id_poster])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
