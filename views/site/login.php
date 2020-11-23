<?php

use yii\helpers\Html;

use icms\FomanticUI\widgets\ActiveForm;
use icms\FomanticUI\Elements;

$this->title = Yii::t('app', 'Log in');
$this->params['breadcrumbs'][] = $this->title;

$form = 
    ActiveForm::begin([
        'id' => 'login-form',
        'enableClientValidation' => false,
        'options' => [
            'autocomplete' => 'off',
            'class' => 'ui form',
        ],
    ]); ?>

<div class="ui centered three column grid">
    <div class="five wide computer eight wide tablet sixteen wide mobile column">
        <div class="ui top attached header">
            <?= Elements::label('', ['class' => 'blue empty tiny circular'] ) ?>&nbsp;
            <?= Html::encode( $this->title ) ?>
        </div>

        <div class="ui attached segment">
            <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('app', 'Username or Email address'), 'autofocus' => true])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(false) ?>

            <?php $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="ui hidden divider"></div>

            <?= Html::submitButton('Log in', ['class' => 'fluid ui primary button', 'name' => 'login-button']) ?>
        </div>
    </div>

    <div class="ui centered row">
        <?= Html::a(Yii::t('app', 'Forgot Password?'), ['site/request-password-reset'], ['id' => 'forgot_pwd', 'class' => 'ui center aligned tiny grey']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
