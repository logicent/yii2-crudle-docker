<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use icms\FomanticUI\helpers\Size;
use icms\FomanticUI\modules\Modal;
use icms\FomanticUI\Elements;
use app\models\DocTypeField;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocTypeFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

    <h3 class="ui header"><?= Yii::t('app', 'Field') ?></h3>

    <p>
        Customize the label, hide on print, default value, etc ...
    </p>

    <?= GridView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'tableOptions'=> ['class' => 'ui padded table'],
        'emptyText' => Yii::t('app', "No fields defined."),
        'emptyTextOptions' => ['class' => 'ui small header center aligned text-muted'], 
        'columns' => [
            // ['class' => 'icms\FomanticUI\widgets\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'label',
                'value' => function($model, $key, $index, $column){
                            return Html::activeTextInput($model, "[$index]label", ['data' => ['modal-input' => 'label']]);
                        },
                'format' => 'raw'
            ],
            [
                'attribute' => 'type',
                'value' => function($model, $key, $index, $column){
                            return Html::activeDropDownList($model, "[$index]type", DocTypeField::getListOptions()  , ['data' => ['modal-input' => 'type']]);
                        },
                'format' => 'raw'
            ],
            [
                'attribute' => 'name',
                'value' => function($model, $key, $index, $column){
                            return Html::activeTextInput($model, "[$index]name", ['data' => ['modal-input' => 'name']]);
                        },
                'format' => 'raw'
            ],
            [
                'attribute' => 'mandatory',
                'value' => function($model, $key, $index, $column){
                            return Html::activeCheckbox($model, "[$index]mandatory", ['data' => ['modal-input' => 'mandatory']]);
                        },
                'format' => 'raw'
            ],
            [
                'attribute' => 'options',
                'value' => function($model, $key, $index, $column){
                            return Html::activeTextInput($model, "[$index]options", ['data' => ['modal-input' => 'options']]);
                        },
                'format' => 'raw'
            ],
            [
                'format' => 'raw',
                'value' => function( $model, $key, $index, $column ) {
                    return 
                        Html::activeHiddenInput($model, "[$index]updateType",
                            ['class' => 'update-type', 'data' => ['modal-input' => 'doc_type']] ) .
                        Html::activeHiddenInput($model, "[$index]doc_type", ['data' => ['modal-input' => 'doc_type']]) .
                        Html::activeHiddenInput($model, "[$index]length", ['data' => ['modal-input' => 'length']]) .
                        Html::activeHiddenInput($model, "[$index]unique", ['data' => ['modal-input' => 'unique']]) .
                        Html::activeHiddenInput($model, "[$index]in_list_view", ['data' => ['modal-input' => 'in_list_view']]) .
                        Html::activeHiddenInput($model, "[$index]in_standard_filter", ['data' => ['modal-input' => 'in_standard_filter']]) .
                        Html::activeHiddenInput($model, "[$index]in_global_search", ['data' => ['modal-input' => 'in_global_search']]) .
                        Html::activeHiddenInput($model, "[$index]bold", ['data' => ['modal-input' => 'bold']]) .
                        Html::activeHiddenInput($model, "[$index]allow_in_quick_entry", ['data' => ['modal-input' => 'allow_in_quick_entry']]) .
                        Html::activeHiddenInput($model, "[$index]translatable", ['data' => ['modal-input' => 'translatable']]) .
                        Html::activeHiddenInput($model, "[$index]fetch_from", ['data' => ['modal-input' => 'fetch_from']]) .
                        Html::activeHiddenInput($model, "[$index]fetch_if_empty", ['data' => ['modal-input' => 'fetch_if_empty']]) .
                        Html::activeHiddenInput($model, "[$index]depends_on", ['data' => ['modal-input' => 'depends_on']]) .
                        Html::activeHiddenInput($model, "[$index]ignore_user_permissions", ['data' => ['modal-input' => 'ignore_user_permissions']]) .
                        Html::activeHiddenInput($model, "[$index]allow_on_submit", ['data' => ['modal-input' => 'allow_on_submit']]) .
                        Html::activeHiddenInput($model, "[$index]report_hide", ['data' => ['modal-input' => 'report_hide']]) .
                        Html::activeHiddenInput($model, "[$index]perm_level", ['data' => ['modal-input' => 'perm_level']]) .
                        Html::activeHiddenInput($model, "[$index]hidden", ['data' => ['modal-input' => 'hidden']]) .
                        Html::activeHiddenInput($model, "[$index]readonly", ['data' => ['modal-input' => 'readonly']]) .
                        Html::activeHiddenInput($model, "[$index]mandatory_depends_on", ['data' => ['modal-input' => 'mandatory_depends_on']]) .
                        Html::activeHiddenInput($model, "[$index]readonly_depends_on", ['data' => ['modal-input' => 'readonly_depends_on']]) .
                        Html::activeHiddenInput($model, "[$index]default", ['data' => ['modal-input' => 'default']]) .
                        Html::activeHiddenInput($model, "[$index]description", ['data' => ['modal-input' => 'description']]) .
                        Html::activeHiddenInput($model, "[$index]in_filter", ['data' => ['modal-input' => 'in_filter']]) .
                        Html::activeHiddenInput($model, "[$index]print_hide", ['data' => ['modal-input' => 'print_hide']]) .
                        Html::activeHiddenInput($model, "[$index]print_width", ['data' => ['modal-input' => 'print_width']]) .
                        Html::activeHiddenInput($model, "[$index]width", ['data' => ['modal-input' => ']width']]);
                }
            ],
            [
                'class' => 'icms\FomanticUI\widgets\ActionColumn',
                'buttons' => [
                    'view' => function ( $url, $model, $key ) 
                    {
                        return false;
                    },
                    'delete' => function ( $url, $model, $key ) 
                    {
                        return false;
                    },
                    'update' => function ( $url, $model, $key ) 
                    {
                        return 
                            Html::a(Elements::icon('pencil alternate'), ['doc-type-field/update'],
                                    [
                                        'class' => 'ui button load-field-modal',
                                        'title' => Yii::t('yii', 'Update'),
                                    ]);
                    },
                ],
            ],
        ],
    ]); ?>

    <div class="ui hidden divider"></div>
    <?php
        if ( !$isReadonly ) :
            echo 
                Html::button(Yii::t('app', 'Delete'), 
                    [
                        'class' => 'delete-button ui mini red button', 
                        'style' => 'display:none',
                    ]) .
                Html::submitButton(Yii::t('app', 'Add row'), [
                    'class' => 'ui mini button',
                    'name' => 'addRow',
                ]);
        endif
    ?>

<?php 
    $modal = Modal::begin([
        'id' => 'field_modal',
        'size' => Size::MEDIUM,
    ]);
    // echo $this->render('_form', [
    //     'model' => new DocTypeField(),
    // ]);
    $modal::end();

$this->registerJs(<<<JS
    $('.load-field-modal').on('click', function(e)
    {
        e.stopPropagation(); // !! DO NOT use return false; it stops execution
        rowInputs = $(e.target).closest('tr').find(":input" );
        $.each(rowInputs, (index, input) => {
            $(input).attr('name', $(input).data('modal-input'));
            // console.log(input);
        });

        $.ajax({
            url: $(this).attr('href'),
            type: 'post',
            data: {
                _csrf: yii.getCsrfToken(),
                'data': rowInputs.serializeArray(),
            },
            success: function( response )
            {
                $('#field_modal .content').html( response );
                $('#field_modal').modal({ closable : false })
                                .modal('show'); // !!! Use the modal#id not '.ui.modal' to avoid load issues
            },
            error: function( jqXhr, textStatus, errorThrown )
            {
                console.log( errorThrown );
            }
        });
        return false;
    })
JS); ?>

<?php $this->registerJs("
    $('.delete-button').click(function() {
        var detail = $(this).closest('tr');
        var updateType = detail.find('.update-type');
        if (updateType.val() === " . json_encode(DocTypeField::UPDATE_TYPE_UPDATE) . ") {
            //marking the row for deletion
            updateType.val(" . json_encode(DocTypeField::UPDATE_TYPE_DELETE) . ");
            detail.hide();
        } else {
            //if the row is a new row, delete the row
            detail.remove();
        }

    });
");
?>