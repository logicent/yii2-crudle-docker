<?php

namespace app\controllers;

use Yii;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

use app\models\forms\ReportBuilderForm;

class ReportsController extends BaseController
{
    public function init()
    {
        $this->sidebar = '_sidebarNav';
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ReportBuilderForm();

        return $this->render('index', [
            'model'=> $model
        ]);
    }

    public function actionQueryBuilder()
    {
        $model = new ReportBuilderForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if (is_array($model->select_columns))
                $select_columns = implode(',', $model->select_columns);
            else
                $select_columns = '*';
            
            $pk = Yii::$app->db->getTableSchema($model->source_table)->primaryKey;

            $count = Yii::$app->db->createCommand('
                SELECT COUNT(' . implode(',', $pk) . ') FROM `' . $model->source_table . '`')->queryScalar();

            $provider = new SqlDataProvider([
                'sql' => 'SELECT ' . $select_columns . ' FROM `' . $model->source_table . '`',
                // 'params' => [':status' => 1],
                'totalCount' => $count,
                'pagination' => [
                    'pageSize' => 10,
                ],
                // 'sort' => [
                //     'attributes' => [
                //         $model->order_by_columns
                //     ],
                // ],
            ]);
        }
        else {
            return $this->redirect(['index']);
        }

        return $this->render('builder/index', [
            'dataProvider' => $provider
        ]);
    }

    public function actionGetTableColumns()
    {
        if (Yii::$app->request->isAjax)
        {
            $model = new ReportBuilderForm();
            $model->source_table = Yii::$app->request->get('source_table');

            return $this->renderAjax('_tableColumns', 
                [
                    'model' => $model
                ]);
        }
    }
}
