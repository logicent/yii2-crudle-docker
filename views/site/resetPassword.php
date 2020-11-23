<?php

use yii\helpers\Html;
use Zelenin\yii\SemanticUI\widgets\ActiveForm;
use Zelenin\yii\SemanticUI\Elements;

$this->title = Yii::t('app', 'Reset Password');

$fieldOptions = [
    'options' => ['class' => 'form-group has-feedback'],
    // 'inputTemplate' => "{input}<span class='fa fa-lock form-control-feedback'></span>"
];
$form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

<div class="ui centered three column grid">
    <div class="five wide computer eight wide tablet sixteen wide mobile column">
        <div class="ui top attached header">
            <?= Elements::label('', ['class' => 'blue empty tiny circular'] ) ?>&nbsp;
            <?= Html::encode($this->title) ?>
        </div>

        <div class="ui attached segment">
            <?= $form->field($model, 'password', $fieldOptions)
                    ->label(false)
                    ->passwordInput(['placeholder' => Yii::t('app', 'New Password')]) ?>

            <div class="ui divider hidden"></div>

            <?= Html::submitButton(Yii::t('app', 'Reset Password'), ['class' => 'ui primary button']) ?>
        </div><!-- /.ui attached segment -->
    </div><!-- /.ui column -->
</div><!-- /.ui centered three column grid -->

<?php ActiveForm::end(); ?>
