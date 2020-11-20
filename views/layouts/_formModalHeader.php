<?php

use yii\helpers\Html;

// use app\assets\DirrtyAsset;

// DirrtyAsset::register($this);
?>

<div class="ui secondary top attached segment">
    <div class="ui grid">
        <div class="ten wide column">
            <div class="ui floated header" style="font-weight: 500">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
        <div class="six wide column right aligned">
            <!-- If form is dirty !!! then show reminder to save -->
            <!-- <span class="app-status-label app-hidden">
                <i class="ui mini yellow empty circular label"></i>&ensp;<?php // Yii::t('app', 'Not Saved') ?>&ensp;
            </span> -->
            <?= Html::submitButton(Yii::t('app', 'Save'), [
                    'id' => 'submit',
                    'class' => 'compact ui small primary button']) ?>
        </div>
    </div>
</div>

<?php 
// $this->render('/layouts/_flashMessage', ['context' => $this->context]);
// $this->registerJs(<<<JS
//     $('.ui.form').dirrty({
//         preventLeaving : false,
//         // leavingMessage: 'Your unsaved changes will be lost', // ignored by browser and overridden
//     }).on('dirty', 
//         function() {
//             $('.app-status-label').toggleClass('app-hidden');
//     }).on('clean', 
//         function() {
//             $('.app-status-label').toggleClass('app-hidden');
//     });
// JS
// );
?>