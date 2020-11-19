<?php

use yii\helpers\Html;
// use yii\helpers\Url;
use icms\FomanticUI\collections\Breadcrumb;
use icms\FomanticUI\collections\Menu;
use icms\FomanticUI\Elements;

?>
<!-- top fixed -->
<nav id="main" class="ui basic segment">
    <div class="ui grid">
        <div class="column header item" id="app_icon">
            <div class="compact ui icon buttons">
              <?= Html::a( Yii::$app->params['appShortName'], ['/'], [ 'class' => 'ui blue button' ] ) ?>
            </div>
        </div>

        <div class="computer only large screen only eight wide column item">
        <?php
            if ( $this->context->showBreadcrumb ) :
                echo Breadcrumb::widget([
                        'divider' => Breadcrumb::DIVIDER_CHEVRON,
                        'homeLink' => [
                            'label' => '', // sets divider only to point back at ME icon buttons
                        ],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
            endif ?>
        </div>

        <div class="computer only large screen only six wide column right aligned menu">
    <?php 
        if ( is_null( Yii::$app->user->identity ) ) :
            echo Html::a(Yii::t('app', 'Log in'), ['site/login'], ['class' => 'item']);
        else : ?>
            <div class="ui dropdown item right aligned">
                <img class="ui mini image circular" src="' . Yii::$app->urlManager->baseUrl . '/img/photo-ph.jpg">' ?>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <?= Html::a(Yii::t('app', 'My Account'), ['people/update', 'id' => Yii::$app->user->id], ['class' => 'item']) ?>
                    <div class="divider"></div>
                    <?= Html::a(Yii::t('app', 'Log out'), ['/logout'], [
                        'class' => 'item',
                        'data' => ['method' => 'post']
                    ]) ?>
                </div>
            </div>        
        <?php endif ?>
        </div><!-- ./right menu -->
    </div>
</nav>
