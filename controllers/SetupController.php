<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

use app\models\Setup;

class SetupController extends BaseController
{
    public function init()
    {
        $this->sidebar = true;
        return parent::init();
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
                        'roles' => ['System Manager', 'Administrator'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        // load the default settings tab
        return $this->render('index', [
        ]);
    }

}
