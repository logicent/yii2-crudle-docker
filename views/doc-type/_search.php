<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'module') ?>

    <?= $form->field($model, 'title_field') ?>

    <?= $form->field($model, 'image_field') ?>

    <?= $form->field($model, 'max_attachments') ?>

    <?php // echo $form->field($model, 'hide_copy') ?>

    <?php // echo $form->field($model, 'is_table') ?>

    <?php // echo $form->field($model, 'quick_entry') ?>

    <?php // echo $form->field($model, 'track_changes') ?>

    <?php // echo $form->field($model, 'track_views') ?>

    <?php // echo $form->field($model, 'allow_auto_repeat') ?>

    <?php // echo $form->field($model, 'allow_import') ?>

    <?php // echo $form->field($model, 'search_fields') ?>

    <?php // echo $form->field($model, 'sort_field') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
