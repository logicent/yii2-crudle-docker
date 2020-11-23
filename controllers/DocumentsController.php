<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

use app\models\Document;
use app\models\FileInfoSearch;

// use yii\imagine\Image;
use yii\web\UploadedFile;
use app\models\forms\UploadForm;

class DocumentsController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['New Document', 'Update Document'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['Delete Document', 'System Manager'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FileInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Document();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->uploadForm->file_upload = UploadedFile::getInstance($model->uploadForm, 'file_upload');
            // $model->size = $model->uploadForm->file_upload->size;
            $model->res_path = $model->uploadForm->upload(); // if saveAs succeeded file_path is returned else false
            if ($model->res_path !== false) {
                if ($model->save())
                    return $this->redirect(Url::previous('go back'));
                // else
                //     \yii\helpers\VarDumper::dump($model->errors,3,true);
            }
            // else
            // return upload errors here
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous('go back'));
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::previous('go back'));
    }

    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLoadModal($parent_id)
    {
        if (Yii::$app->request->isAjax)
        {
            if (empty(Yii::$app->request->post('id')))
                $model = new Document();
            else
                $model = Document::findOne(Yii::$app->request->post('id'));

            $parent_class = Yii::$app->request->post('parent');
            $model->parent = Inflector::id2camel($parent_class); // i.e. either 'Program' or 'Project'

            $model->parent_id = $parent_id;

            return $this->renderAjax('/' . $this->id .'/_form', ['model' => $model]);
        }
        // else
        Yii::$app->end();
    }
}
