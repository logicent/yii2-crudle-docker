<?php

// use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Inflector;

?>

<aside class="computer only large screen only three wide column">
    <div class="ui sticky">
        <div id="sidebar">
            <div class="ui vertical pointing menu">
                <!-- <div class="header item sub-head"></div> -->
                <div class="item">
                    <div class="menu">
                        <?= Html::a( Yii::t('app', 'List'), ['index'], ['class' => 'active item'] ) ?>
                        <?= Html::a( Yii::t('app', 'Documents'), ['documents',
                                        's' => ['parent' => Inflector::id2camel(
                                                            Inflector::singularize($context->id)
                                                        )
                                                ]
                                        ], 
                                    ['class' => 'item'] ) ?>
                        <div class="ui divider"></div>
                        <?= Html::a( Yii::t('app', 'Report Builder'), [$context->id . '/report-builder'], ['class' => 'item'] ) ?>
                    </div><!-- menu -->
                </div><!-- item -->
            </div><!-- ui vertical pointing menu -->
        </div>
    </div>
</aside>
