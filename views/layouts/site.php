<?php

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <div id="site_header">
        <?= $this->render('/layouts/_siteNavbar', ['context' => $this->context]) ?>
    </div>

    <div class="ui container">
        <!-- Add optional Sidebar here -->
        <?= $content ?>
    </div>

    <div class="ui divider"></div>

    <!-- Site copyright and Powered by here -->
    <div class="ui container">
        <div class="ui grid">
            <div class="eight wide column">
                <p>&copy; Your Org <?= date('Y') ?></p>
            </div>
            <div class="eight wide column right aligned">
                <p class="ui small label">DMERL by Appsoft</p>
            </div>
        </div>
    </div>

<?php
$this->registerCssFile("@web/css/site.css");
$this->registerJs(<<<JS
    $('.ui.dropdown').dropdown();

    $('.ui.sticky')
        .sticky({
            context: '#content'
        });
JS);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
