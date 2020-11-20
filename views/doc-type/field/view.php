<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocTypeField */

$this->title = Yii::t('app', '{name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name, 'doc_type' => $model->doc_type]];
?>
<div class="doc-type-field-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
