<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class BaseController extends Controller
{
    public $showSideMenu = false;
    public $showBreadcrumb = true;
    public $showViewSidebar = true;

}
