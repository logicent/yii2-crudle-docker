<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\controllers\BaseController;
use app\models\DocType;
use app\models\DocTypeSearch;
use app\models\DocTypeField;
use app\models\DocTypeFieldSearch;


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
        $model = $this->findModel($id);
        $query = DocTypeField::find()->where(['doc_type' => $model->name]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    // 'created_at' => SORT_DESC,
                    // 'title' => SORT_ASC,
                ],
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
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
        $modelDetails = [];

        $formDetails = Yii::$app->request->post('DocTypeField', []);
        foreach ($formDetails as $i => $formDetail) 
        {
            $modelDetail = new DocTypeField(['scenario' => DocTypeField::SCENARIO_BATCH_UPDATE]);
            $modelDetail->setAttributes($formDetail);
            $modelDetails[] = $modelDetail;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => DocTypeField::find()->where(['doc_type' => '']),
        ]);

        $dataProvider->setModels( !empty($modelDetails) ? $modelDetails :  [new DocTypeField(['scenario' => DocTypeField::SCENARIO_BATCH_UPDATE])] );

        //handling if the addRow button has been pressed
        if ( isset( Yii::$app->request->post()['addRow']) ) 
        {
            $model->load(Yii::$app->request->post());
            $modelDetails[] = new DocTypeField(['scenario' => DocTypeField::SCENARIO_BATCH_UPDATE]);
            $dataProvider->setModels( $modelDetails );

            return $this->render('create', [
                'model' => $model,
                'fieldDataProvider' => $dataProvider,
            ]);
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            if (Model::validateMultiple($modelDetails) && $model->validate()) 
            {
                if ( $model->save(false) ) 
                {
                    foreach($modelDetails as $modelDetail) 
                    {
                        $modelDetail->doc_type = $model->name;
                        $modelDetail->save(false);
                    }
                    $model->createTable();
                }
                return $this->redirect(['view', 'id' => $model->name]);
            }
        }

        return $this->render('create', [
            'model' => $model,
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
        $modelDetails = $model->docTypeFields;

        $formDetails = Yii::$app->request->post('DocTypeField', []);
        foreach ($formDetails as $i => $formDetail) 
        {
            //loading the models if they are not new
            if (isset($formDetail['name']) && isset($formDetail['updateType']) && $formDetail['updateType'] != DocTypeField::UPDATE_TYPE_CREATE) {
                //making sure that it is actually a child of the main model
                $modelDetail = DocTypeField::findOne(['name' => $formDetail['name'], 'doc_type' => $model->name]);
                $modelDetail->setScenario(DocTypeField::SCENARIO_BATCH_UPDATE);
                $modelDetail->setAttributes($formDetail);
                $modelDetails[$i] = $modelDetail;
                //validate here if the modelDetail loaded is valid, and if it can be updated or deleted
            } else {
                $modelDetail = new DocTypeField(['scenario' => DocTypeField::SCENARIO_BATCH_UPDATE]);
                $modelDetail->setAttributes($formDetail);
                $modelDetails[] = $modelDetail;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => DocTypeField::find()->where(['doc_type' => '']),
        ]);

        //handling if the addRow button has been pressed
        if ( isset( Yii::$app->request->post()['addRow']) ) 
        {
            $model->load(Yii::$app->request->post());
            $modelDetails[] = new DocTypeField(['scenario' => DocTypeField::SCENARIO_BATCH_UPDATE]);
            $dataProvider->setModels( $modelDetails );

            return $this->render('update', [
                'model' => $model,
                'fieldDataProvider' => $dataProvider,
            ]);
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            if (Model::validateMultiple($modelDetails) && $model->validate()) 
            {
                if ( $model->save(false) ) 
                {
                    foreach($modelDetails as $modelDetail) 
                    {
                        //details that has been flagged for deletion will be deleted
                        if ($modelDetail->updateType == DocTypeField::UPDATE_TYPE_DELETE) {
                            $modelDetail->delete();
                        } else {
                            //new or updated records go here
                            $modelDetail->doc_type = $model->name;
                            $modelDetail->save(false);
                        }                        
                    }
                    // $model->updateTable(); // TODO: define method in model
                }
                return $this->redirect(['view', 'id' => $model->name]);
            }
            else
            {
                Yii::$app->session->setFlash( 'error', $model->errors);
            }
        }

        $dataProvider->setModels( !empty($modelDetails) ? $modelDetails :  [new DocTypeField(['scenario' => DocTypeField::SCENARIO_BATCH_UPDATE])] );

        return $this->render('update', [
            'model' => $model,
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
