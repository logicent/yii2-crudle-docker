<?php

use yii\helpers\Html;
use yii\grid\GridView;
use icms\FomanticUI\helpers\Size;
use icms\FomanticUI\modules\Modal;
use icms\FomanticUI\Elements;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocTypeFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

    <h3 class="ui header"><?= Yii::t('app', 'Field') ?></h3>

    <p>
        Customize the label, hide on print, default value, etc ...
    </p>

    <?= GridView::widget([
        'layout' => "{items}\n{summary}\n{pager}",
        'dataProvider' => $dataProvider,
        'tableOptions'=> ['class' => 'ui padded table'],
        'emptyText' => Yii::t('app', "No fields defined."),
        'emptyTextOptions' => ['class' => 'ui small header center aligned text-muted'], 
        'columns' => [
            // ['class' => 'icms\FomanticUI\widgets\CheckboxColumn'],

            'label',
            'type',
            'name',
            'mandatory:boolean',
            'options:ntext',
            // 'length',
            //'unique',
            //'in_list_view',
            //'in_standard_filter',
            //'in_global_search',
            //'bold',
            //'allow_in_quick_entry',
            //'translatable',
            //'fetch_from',
            //'fetch_if_empty',
            //'depends_on',
            //'ignore_user_permissions',
            //'allow_on_submit',
            //'report_hide',
            //'perm_level',
            //'hidden',
            //'readonly',
            //'mandatory_depends_on',
            //'readonly_depends_on',
            //'default',
            //'description',
            //'in_filter',
            //'print_hide',
            //'print_width',
            //'width',

            [
                'class' => 'icms\FomanticUI\widgets\ActionColumn',
                'buttons' => [
                    'update' => function ( $url, $model, $key ) 
                    {
                        return 
                            Html::a(Elements::icon('pencil alternate'), ['doc-type-field/update', 
                                        'name' => $model->name, 
                                        'doc_type' => $model->doc_type
                                    ], 
                                    [
                                        'class' => 'ui button load-field-modal',
                                        'title' => Yii::t('yii', 'Update'),
                                    ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return 
                            Html::a(Elements::icon('trash alternate'), ['doc-type-field/update', 
                                    'name' => $model->name, 
                                    'doc_type' => $model->doc_type
                                ],
                                [
                                    'class' => 'ui button',
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post'
                                ]);
                    }
                ]
            ],
        ],
    ]); ?>

    <div class="ui hidden divider"></div>

    <?= Html::a(Yii::t('app', 'Add row'), ['doc-type-field/create'], [
            'class' => 'ui mini button load-field-modal'
        ]) ?>

<?php 
    $modal = Modal::begin([
        'id' => 'field_modal',
        'size' => Size::MEDIUM,
    ]);
    $modal::end();

$this->registerJs(<<<JS
    $('.load-field-modal').on('click', function(e)
    {
        e.stopPropagation(); // !! DO NOT use return false; it stops execution

        $.ajax({
            url: $(this).attr('href'),
            type: 'post',
            data: {'id': $(this).data('id'), _csrf: yii.getCsrfToken()},
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