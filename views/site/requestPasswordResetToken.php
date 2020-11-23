<?php

use yii\helpers\Html;
use Zelenin\yii\SemanticUI\widgets\ActiveForm;
use Zelenin\yii\SemanticUI\Elements;

$this->title = Yii::t('app', 'Forgot Password?');

$fieldOptions = [
    'options' => ['class' => 'form-group has-feedback'],
    // 'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
];
$form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

<div class="ui centered three column grid">
    <div class="five wide computer eight wide tablet sixteen wide mobile column">
        <div class="ui top attached header">
            <?= Elements::label('', ['class' => 'blue empty tiny circular'] ) ?>&nbsp;
            <?= Html::encode($this->title) ?>
        </div>
        <div class="ui attached segment">
            <?= $form->field($model, 'email', $fieldOptions)
                ->label(false)
                ->textInput(['placeholder' => Yii::t('app', 'Your email address')]) ?>

            <div class="ui divider hidden"></div>

            <?= Html::submitButton(Yii::t('app', 'Submit Request'), ['class' => 'fluid ui primary button']) ?>
        </div><!-- /.ui attached segment -->
    </div><!-- /.ui column -->

    <div class="ui centered row">
        <?= Html::a(Elements::icon('left arrow') .'&ensp;'. Yii::t('app', 'Back to Log in'), ['site/login'], ['id' => 'forgot_pwd', 'class' => 'ui center aligned tiny grey']) ?>
    </div>
</div><!-- /.ui centered three column grid -->

<?php ActiveForm::end(); ?>
