<?php

// use icms\FomanticUI\collections\Message;

if (Yii::$app->session->hasFlash('warning')) : ?>
  <div class="ui warning message">
    <i class="close icon"></i>
    <div class="header">
      <?= Yii::$app->session->getFlash('warning') ?>
    </div>
    <p><?= Yii::$app->session->getFlash('description') ?></p>
  </div>
<?php
endif;

if (Yii::$app->session->hasFlash('info')) : ?>
  <div class="ui info message">
    <i class="close icon"></i>
    <div class="header">
      <?= Yii::$app->session->getFlash('info') ?>
    </div>
    <p><?= Yii::$app->session->getFlash('description') ?></p>
    <!-- <ul class="list">
        <li>Did you know it's been a while?</li>
      </ul> -->
  </div>
<?php
endif;

if (Yii::$app->session->hasFlash('success')) : ?>
  <div class="ui positive message">
    <i class="close icon"></i>
    <div class="header">
      <?= Yii::$app->session->getFlash('success') ?>
    </div>
    <p><?= Yii::$app->session->getFlash('description') ?></p>
  </div>
<?php
endif;

if (Yii::$app->session->hasFlash('error')) : ?>
  <div class="ui negative message">
    <i class="close icon"></i>
    <div class="header">
      <?= Yii::$app->session->getFlash('error') ?>
    </div>
    <p><?= Yii::$app->session->getFlash('description') ?></p>
  </div>
<?php
endif;

$this->registerJs(<<<JS
  $('.message .close')
      .on('click', function() {
          $(this)
          .closest('.message')
          .transition('fade');
  });
JS) ?>