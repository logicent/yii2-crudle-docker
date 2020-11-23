<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

class CommentForm extends Model
{
    // 'User (CRUD) Action','User Remark','System Task' (e.g. Email or Print?)
    // The comments property attribute in BaseAR should be encoded/decoded using this model
    // avatar, liked_by, user_tags

    const COMMENT_TYPE_TIMESTAMP = 'TS';
    const COMMENT_TYPE_REMARKS = 'PR';

    public $comment;
    public $type;
    public $created_at;
    public $created_by; // user id
    public $commenter; // user full name

    public function init()
    {
        $this->type =  [
            self::COMMENT_TYPE_TIMESTAMP => Yii::t('app', 'Audit Timestamp'),
            self::COMMENT_TYPE_REMARKS => Yii::t('app', 'Person Remarks')
        ];
    }

    public function rules()
    {
        return [
            [['created_at', 'created_by', 'type', 'comment'], 'required'],
            [['commenter'], 'safe'],
            // [['comment'], 'string', 'skipOnEmpty' => false, 'max' => ''],
        ];
    }

    public function save ( &$model, $json_decode = false, $type = self::COMMENT_TYPE_TIMESTAMP )
    {
        $this->created_at = time();
        $this->created_by = Yii::$app->user->id;

        if ($this->validate())
        {   // !! append comments array in parent model
            // check why the comments here differ in modal/form
            $all_comments = $json_decode ? Json::decode($model->comments) : $model->comments;
            $all_comments[ $this->created_at ] = [
                                        'created_by' => $this->created_by,
                                        'type' => $type,
                                        'notes' => $this->comment
                                    ];
            $model->comments = $all_comments;

            if ($model->save(false)) // skip validation
                return true;
        }

        return false;
    }
}
