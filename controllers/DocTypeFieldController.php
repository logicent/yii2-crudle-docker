<?php

namespace app\controllers;

use Yii;
use app\models\DocTypeField;
use app\models\DocTypeFieldSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * DocTypeFieldController implements the CRUD actions for DocTypeField model.
 */
class DocTypeFieldController extends Controller
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
     * Lists all DocTypeField models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocTypeFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/doc-type/field/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocTypeField model.
     * @param string $name
     * @param string $doc_type
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name, $doc_type)
    {
        return $this->renderAjax('/doc-type/field/view', [
            'model' => $this->findModel($name, $doc_type),
        ]);
    }

    /**
     * Creates a new DocTypeField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocTypeField();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->asJson(['success' => true]);
            } else {
                $result = [];
                foreach ($model->getErrors() as $attribute => $errors)
                    $result[\yii\helpers\Html::getInputId($model, $attribute)] = $errors;
                return $this->asJson(['validation' => $result]);
            }
        }

        $model->doc_type = Yii::$app->request->post('name');

        return $this->renderAjax('/doc-type/field/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocTypeField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name
     * @param string $doc_type
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = new DocTypeField();
        $details = ArrayHelper::map(  Yii::$app->request->post('data'), 'name', 'value' );
        $model->attributes = $details;
        
        return $this->renderAjax('/doc-type/field/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocTypeField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @param string $doc_type
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name, $doc_type)
    {
        $this->findModel($name, $doc_type)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocTypeField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name
     * @param string $doc_type
     * @return DocTypeField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name, $doc_type)
    {
        if (($model = DocTypeField::findOne(['name' => $name, 'doc_type' => $doc_type])) !== null) {
            return $model;
        }
        // else
        return new DocTypeField();
    }
}
