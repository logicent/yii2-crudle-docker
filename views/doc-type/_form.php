<?php

use yii\helpers\Html;
use icms\FomanticUI\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocType */
/* @var $form \icms\FomanticUI\widgets\ActiveForm */

$isReadonly = $this->context->action->id == 'view';

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableClientValidation' => false,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'ui form'
    ],
]);
   
echo $this->render('/layouts/_formHeader', ['model' => $model]) ?>

<div class="ui attached segment">
    <div class="two fields">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => $isReadonly]) ?>
    </div>
</div>

<div class="ui attached segment">
    <div class="ui two column grid">
        <div class="column">
            <?= $form->field( $model, 'module' )->dropDownList( [
                'Core' => 'Core'
            ] ) ?>
            <?= $form->field( $model, 'max_attachments' )->textInput( ['readonly' => $isReadonly]) ?>
            <?= $form->field($model, 'search_fields', [
                    'hintOptions' => [
                        'class' => 'small'
                    ]
                ])->textarea(['rows' => 3, 'readonly' => $isReadonly]
                )->hint('Fields separated by a comma (,) will be included in the "Search by" list of the search dialog') ?>            
        </div>
        <div class="column">
            <?= $form->field($model, 'hide_copy')->checkbox() ?>
            <?= $form->field($model, 'is_table')->checkbox() ?>
            <?= $form->field($model, 'quick_entry')->checkbox() ?>
            <?= $form->field($model, 'track_changes')->checkbox() ?>
            <?= $form->field($model, 'track_views')->checkbox() ?>
            <?= $form->field($model, 'allow_auto_repeat')->checkbox() ?>
            <?= $form->field($model, 'allow_import')->checkbox() ?>            
        </div>
    </div>
</div>
<div class="ui attached segment">
    <?= $this->render('field/index', [
            'dataProvider' => $fieldDataProvider, 
            'searchModel' => $fieldSearchModel
        ]) ?>
</div>
<div class="ui attached segment">
    <div class="ui two column grid">
        <div class="column">
            <?= $form->field( $model, 'title_field' )->textInput( ['maxlength' => true, 'readonly' => $isReadonly]) ?>
            <?= $form->field( $model, 'image_field' )->textInput( ['maxlength' => true, 'readonly' => $isReadonly]) ?>
        </div>
    </div>
</div>
<!-- <div class="ui bottom attached segment"> -->
    <div class="ui styled fluid accordion">
        <div class="title">
            <i class="angle right icon"></i>List settings
        </div>
        <div class="content">
            <div class="two fields">
                <?= $form->field( $model, 'sort_field' )->dropDownList([]) ?>
                <?= $form->field( $model, 'sort_order' )->dropDownList([
                    'ASC' => 'Ascending',
                    'DESC' => 'Descending'
                ]) ?>
            </div>
        </div>
    </div>
<!-- </div> -->

    <?= Html::activeHiddenInput($model, 'created_by') ?>
    <?= Html::activeHiddenInput($model, 'updated_by') ?>
    <?= Html::activeHiddenInput($model, 'created_at') ?>
    <?= Html::activeHiddenInput($model, 'updated_at') ?>
    <?= Html::activeHiddenInput($model, 'deleted_at') ?>

<?php ActiveForm::end();
$this->registerJS(<<<JS
    $('.ui.accordion').accordion();
JS)
?>

<?php //= $this->render('/layouts/_formFooter', ['model' => $model]) ?>