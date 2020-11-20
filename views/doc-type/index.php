<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use \icms\FomanticUI\widgets\GridView;
use \icms\FomanticUI\widgets\Pjax;
use \icms\FomanticUI\Elements;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$resource = $this->context->id;
$this->title = Yii::t('app', Inflector::id2camel($resource));

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-type-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=> ['class' => 'ui padded table'],
        'emptyText' => Yii::t('app', "No {$resource} found."),
        'emptyTextOptions' => ['class' => 'ui small header center aligned text-muted'], 
        'columns' => [
            ['class' => '\icms\FomanticUI\widgets\CheckboxColumn'],

            'name',
            'module',
            'is_table:boolean',
            'updated_at',

            ['class' => '\icms\FomanticUI\widgets\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
