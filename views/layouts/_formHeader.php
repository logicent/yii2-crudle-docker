<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Inflector;
use Zelenin\yii\SemanticUI\Elements;

// use app\assets\DirrtyAsset;

// DirrtyAsset::register($this);

?>

<div class="ui top attached secondary segment">
    <div class="ui two column grid">
        <div class="column">
        <?php
            // if (!$model->isNewRecord && $model->hasWorkflow && array_key_exists('status', $model->attributes)) :
            //     echo $this->render($this->context->statusMenu, ['model' => $model]);
            // endif ?>
        </div>

        <div class="column right aligned">
            <!-- If form is dirty !!! then show reminder to save -->
            <!-- <span class="app-status-label app-hidden">
                <i class="ui mini yellow empty circular label"></i>&ensp;<?php //= Yii::t('app', 'Not Saved') ?>&ensp;
            </span> -->
        <?php
            // if (!$model->isNewRecord) :
            //     echo $this->render('/layouts/_menu', ['model' => $model]);
            //     // Html::a(Elements::icon('print', ['class' => 'grey']), Url::toRoute('print', ['id' => $model->{$model->primaryKey()[0]}]));
            // endif;

            if ($this->context->action->id == 'view' && 
                Yii::$app->user->can('Update ' . Inflector::id2camel(Inflector::singularize($this->context->id)))) :
                echo Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'compact ui small primary button']);
            endif;

            if ($this->context->action->id == 'create' || $this->context->action->id == 'update') :
                echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'compact ui small primary button']);
            endif ?>
        </div><!-- ./column right aligned -->
    </div><!-- ./two column grid -->
</div><!-- ./ui top segment -->

<?php 
$this->render('/layouts/_flashMessage', ['context' => $this->context]);

if ($this->context->action->id != 'view') :
    $this->registerJs(<<<JS
        // $('.ui.form').dirrty({
        //     preventLeaving : false,
        //     // leavingMessage: 'Your unsaved changes will be lost', // ignored by browser and overridden
        // }).on('dirty', 
        //     function() {
        //         $('.app-status-label').toggleClass('app-hidden');
        // }).on('clean', 
        //     function() {
        //         $('.app-status-label').toggleClass('app-hidden');
        // });
    JS);
endif;

$this->registerJs(<<<JS
    $('.ui.dropdown').dropdown({
        // action: 'hide',
        // onChange: function(value, text, selectedItem) {
        //     console.log(value, text. selectedItem)
        // }
        // clearable : true,
        // values : listOptions, // get values from JS global var of listOptions
        // placeholder : 'Choose',
    });

    // $('.pikaday').flatpickr({
        // minDate : null,
        // maxDate : null,
        // altInput : true,
        // allowInput : false,
        // clickOpens : true,
        // shorthandCurrentMonth : false,
        // time_24hr : false
        // weekNumbers : false
    // });

    // $('.pikadaytime').flatpickr({
    //     minuteIncrement: 15,
    //     enableTime: true
    // });
JS
);
?>