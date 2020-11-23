<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "email".
 *
 */
class Email extends ActiveRecord
{
    public static function tableName()
    {
        return 'email';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by'],
                ],
                'value' => function () {
                    if ( is_a( Yii::$app, 'yii\console\Application') )
                    {
                        $authMan = Yii::$app->authManager;
                        $userId = $authMan->getUserIdsByRole( 'System Manager' );
                        $value = $userId[0];
                    }
                    else
                        $value = Yii::$app->get('user')->id;
                    return $value;
                }
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => function ($event) {
                    return new \yii\db\Expression('NOW()');
                },
            ]
        ];
    }

    public function rules()
    {
        return [
            [['from', 'to', 'subject', 'message'], 'required'],
            [['cc', 'message', 'attachments'], 'string'],
            [['send_as_email', 'send_me_a_copy'], 'integer'],
            [['created_at', 'sent_at'], 'safe'],
            [['from', 'to', 'subject'], 'string', 'max' => 140],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'cc' => Yii::t('app', 'Cc'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'send_as_email' => Yii::t('app', 'Send as Email'),
            'send_me_a_copy' => Yii::t('app', 'Send me a Copy'),
            'attachments' => Yii::t('app', 'Attachments'),
            'created_at' => Yii::t('app', 'Created At'),
            'sent_at' => Yii::t('app', 'Sent At'),
        ];
    }
}
