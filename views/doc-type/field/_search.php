<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocTypeFieldSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-type-field-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'doc_type') ?>

    <?= $form->field($model, 'label') ?>

    <?= $form->field($model, 'length') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'options') ?>

    <?php // echo $form->field($model, 'mandatory') ?>

    <?php // echo $form->field($model, 'unique') ?>

    <?php // echo $form->field($model, 'in_list_view') ?>

    <?php // echo $form->field($model, 'in_standard_filter') ?>

    <?php // echo $form->field($model, 'in_global_search') ?>

    <?php // echo $form->field($model, 'bold') ?>

    <?php // echo $form->field($model, 'allow_in_quick_entry') ?>

    <?php // echo $form->field($model, 'translatable') ?>

    <?php // echo $form->field($model, 'fetch_from') ?>

    <?php // echo $form->field($model, 'fetch_if_empty') ?>

    <?php // echo $form->field($model, 'depends_on') ?>

    <?php // echo $form->field($model, 'ignore_user_permissions') ?>

    <?php // echo $form->field($model, 'allow_on_submit') ?>

    <?php // echo $form->field($model, 'report_hide') ?>

    <?php // echo $form->field($model, 'perm_level') ?>

    <?php // echo $form->field($model, 'hidden') ?>

    <?php // echo $form->field($model, 'readonly') ?>

    <?php // echo $form->field($model, 'mandatory_depends_on') ?>

    <?php // echo $form->field($model, 'readonly_depends_on') ?>

    <?php // echo $form->field($model, 'default') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'in_filter') ?>

    <?php // echo $form->field($model, 'print_hide') ?>

    <?php // echo $form->field($model, 'print_width') ?>

    <?php // echo $form->field($model, 'width') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
