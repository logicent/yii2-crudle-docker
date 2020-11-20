<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class BaseController extends Controller
{
    public $showBreadcrumb = true;
    public $showViewHeader = true;
    public $showViewSidebar = true;
    // public $showSideMenu = false;

}
