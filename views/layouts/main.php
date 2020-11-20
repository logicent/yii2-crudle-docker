<?php
use yii\helpers\Html;
use \icms\FomanticUI\collections\Breadcrumb;
use app\assets\AppAsset;

/* @var \yii\web\View $this */
/* @var string $content */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <header id="app_head">
    <?php
        echo $this->context->renderPartial( '/layouts/partials/_main_navbar', ['context' => $this->context] );
        if ($this->context->showViewHeader) :
            echo $this->context->renderPartial( '/layouts/partials/_view_header', ['context' => $this->context] );
        endif ?>
    </header>

    <section id="app_body" class="ui basic segment">
        <?php $this->context->renderPartial( '/layouts/partials/_flash_message', ['context' => $this->context] ) ?>
        <div class="ui stackable grid">
        <?php 
            // if ( $this->context->showViewSidebar ) :
            //     if ( file_exists( $this->context->viewPath . '_view_sidebar.php' ) ) :
            //         echo $this->context->renderPartial( '_view_sidebar', ['context' => $this->context] );
            //     else :
            //         echo $this->context->renderPartial( '/layouts/partials/_view_sidebar', ['context' => $this->context] );
            //     endif;
            // endif ?>

            <!-- <div id="content" class="<?php //= $this->context->showViewSidebar ? 'thirteen' : 'sixteen' ?> wide column"> -->
            <div id="content" class="sixteen wide column">
                <?= $content ?>
            </div>
        </div>
    </section>
<?php 
    $this->registerJs($this->render('main.js'));

    $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
