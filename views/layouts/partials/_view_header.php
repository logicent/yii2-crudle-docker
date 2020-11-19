<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use icms\FomanticUI\Elements;

?>
<!--  style="margin-top: 38.4667px;" -->
<header id="view_head" class="ui attached segment">
    <div class="ui two column grid">
        <div class="ten wide column">
            <div class="ui floated header">
                <?= Html::encode($this->title) ?>
            </div>
        </div>

        <div class="six wide column right aligned">
        <?php
            // \Kint::dump($this->context->action);
            if ( $this->context->action->id == 'index' && $this->context->id != 'setup' ) :
                // echo Html::a(Yii::t('app', 'Refresh'), ['refresh'], ['class' => 'compact ui small button']);
                if ( Yii::$app->user->can('New ' . Inflector::id2camel(
                                                    Inflector::singularize($this->context->id)
                                                ))) :
                    echo Html::a( Yii::t('app', 'New'), ['create'], ['class' => 'compact ui small primary button'] );
                endif;
                if ( Yii::$app->user->can('Delete ' . Inflector::id2camel(
                                                        Inflector::singularize($this->context->id)
                                                    ))) :
                    echo Html::a( Yii::t('app', 'Delete'), ['deleteCheckedRows', 'data-checkedRowIds' => ''], [
                        'class' => 'compact ui small red button',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                        'style' => 'display: none'
                    ] );
                endif;
            endif ?>
        </div>
    </div>
</header>
