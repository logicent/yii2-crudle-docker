<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Setup;

$org_profile = Setup::find()->where(['in', 'attribute', ['logoPath', 'name']])
                    ->andWhere(['model' => 'OrgProfile'])
                    ->asArray()
                    ->all();
if (!empty($org_profile)) :
    $this->params['orgLogo'] = $org_profile[0]['value'];
    $this->params['orgName'] = $org_profile[1]['value'];
endif
?>

<div class="ui attached menu borderless">
    <div class="ui container">
    <?php
        if (!empty($this->params['orgLogo'])) : ?>
        <div class="logo">
            <img class="ui small image" src="<?= Yii::getAlias('@web/uploads/') . $this->params['orgLogo']?>">
        </div>
    <?php 
        else : ?>
        <div class="item">
            <div class="ui header text-muted" style="font-weight: 500;">
                <?= !empty($this->params['orgName']) ? $this->params['orgName'] : Yii::t('app', 'Your Logo') ?>
            </div>
        </div>
    <?php 
        endif ?>
        <div class="right menu">
            <?php if (Yii::$app->user->isGuest) : ?>
                <a class="item" href="<?= Url::toRoute('site/login') ?>"><?= Yii::t('app', 'Log in') ?></a>
            <?php else : ?>
                <!-- Published menu items -->
                <div class="ui dropdown item">
                    <!-- <img class="ui mini image" src="<?php // Yii::$app->urlManager->baseUrl ?>/img/photo-ph.jpg"> -->
                    &ensp;<?= Yii::$app->user->identity->username ?><i class="dropdown icon"></i>
                    <div class="menu">
                        <?= Html::a(Yii::t('app', 'My Account'), ['people/update', 'id' => is_null( Yii::$app->user->identity ) ? '' : Yii::$app->user->id], ['class' => 'item']) ?>
                        <?= Html::a(Yii::t('app', 'Switch to Dash'), ['/'], ['class' => 'item']) ?>
                        <div class="divider"></div>
                        <?= Html::a(Yii::t('app', 'Log out'), ['/logout'], [
                            'class' => 'item',
                            'data' => ['method' => 'post']
                        ]) ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
