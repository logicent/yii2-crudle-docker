<?php

use yii\helpers\Html;
use yii\helpers\Url;
use Zelenin\yii\SemanticUI\Elements;

use app\models\forms\CommentForm;

$this->params['count_comments'] = $model->commentsCount;

if (!$model->isNewRecord) :
    $comment = new CommentForm(); ?>

    <div id="comment_section" class="ui divider hidden"></div>

    <?= Html::beginForm([$this->context->id . '/save-comment', 'id' => $model->{$model->primaryKey()[0]}], 
            'post', 
            ['class' => 'ui form']); ?>

    <div class="ui attached secondary segment">
        <div class="ui two column grid">
            <div class="column">
                <div class="ui small header text-muted">
                    <?= Yii::t('app', 'Add a comment') ?>
                </div>
            </div>
            <div class="right aligned column">
                <!-- Avoid button element it will cause page refresh -->
                <?= Elements::button(Yii::t('app', 'Comment'), [
                        'id' => 'submit_comment',
                        'class' => 'compact tiny',
                        'data' => [
                            'url' => Url::to([
                                'save-comment', 
                                'model_id' => $model->attributes[$model->primaryKey()[0]], 
                                'model_class' => $model::className()
                            ])
                        ]
                    ]
                ) ?>
            </div>
        </div>
    </div>

    <div class="ui bottom attached segment">
        <?= Html::activeTextarea($comment, 'comment', [
                'class' => 'comment-box',
                'rows' => 2, 
                'style' => 'resize: none;'
            ]) ?>
    </div>

    <?= Html::endForm(); ?>

    <!-- List all system-generated and user created Comments -->
    <div class="ui threaded comments" id="comment_timeline">
    <?php if (is_array($model->comments)) : ?>
        <?= $this->render('/layouts/_comments', ['comments' => $model->comments]) ?>
    <?php endif ?>
    </div>
<?php
endif;

$this->registerJs(<<<JS
    $('#submit_comment').on('click', function(e)
    {
        e.stopPropagation(); // !! DO NOT use return false; it stops execution
        
        commentText = $('.comment-box').val();
        if ( commentText == '')
            return false;
        
        $.ajax({
            url: $(this).data('url'),
            type: 'post',
            data: {'comment_text': commentText, _csrf: yii.getCsrfToken()},
            success: function( response )
            {
                // clear the comment box
                $('.comment-box').val('');
                // update comment timeline below the form
                $('#comment_timeline').html( response );
            },
            error: function( jqXhr, textStatus, errorThrown )
            {
                console.log( errorThrown );
            }
        });
    })
JS); ?>
