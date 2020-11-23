<?php

namespace app\controllers;

use Yii;
use app\models\DocType;
use app\models\DocTypeSearch;
use app\models\DocTypeField;
use app\models\DocTypeFieldSearch;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocTypeController implements the CRUD actions for DocType model.
 */
class DocTypeController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DocType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocType model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new DocTypeFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'fieldSearchModel' => $searchModel,
            'fieldDataProvider' => $dataProvider,            
        ]);
    }

    /**
     * Creates a new DocType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            $model->createTable();
            return $this->redirect(['view', 'id' => $model->name]);
        }

        $searchModel = new DocTypeFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('create', [
            'model' => $model,
            'fieldSearchModel' => $searchModel,
            'fieldDataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing DocType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            $model->createTable();
            return $this->redirect(['view', 'id' => $model->name]);
        }

        $searchModel = new DocTypeFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('update', [
            'model' => $model,
            'fieldSearchModel' => $searchModel,
            'fieldDataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing DocType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DocType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function fieldList()
    {
        $searchModel = new DocTypeFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return [
            'fieldSearchModel' => $searchModel,
            'fieldDataProvider' => $dataProvider,
        ];
    }
}
