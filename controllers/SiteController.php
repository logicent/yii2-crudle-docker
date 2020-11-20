<?php

namespace app\controllers;

use Yii;
use app\controllers\BaseController;

class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Render the homepage
     */
    public function actionIndex()
    {
        return $this->redirect('doc-type/index');
        return $this->render('index');
    }

    /**
     * @return string|\yii\web\Response the maintenance page or a redirect
     * response if not in maintenance mode
     */
    public function actionMaintenance()
    {
        if (empty(Yii::$app->catchAll)) {
            return $this->redirect(Yii::$app->homeUrl);
        }
        Yii::$app->response->statusCode = 503;
        return $this->render('maintenance');
    }
}
