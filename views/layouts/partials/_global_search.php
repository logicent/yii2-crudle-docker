<?php

// use yii\helpers\Html;
// use yii\helpers\Url;
use icms\FomanticUI\widgets\ActiveForm;
use icms\FomanticUI\Elements;

use app\models\forms\GlobalSearch;

$model = new GlobalSearch;

?>

<div id="search_form" class="item">

<!-- onsubmit="return false;" -->
<?php $form = ActiveForm::begin(['action' => ['main/global-search']]) ?>

    <!-- <div class="ui small icon input"> -->
    <?= $form->field($model, 'gs_term')->textInput(['placeholder' => Yii::t('app', 'Search or type a command')])->label(false) ?>
    <?php Elements::icon('search icon') ?>
    <!-- </div> -->

<?php ActiveForm::end() ?>

</div>
