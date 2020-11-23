<?php

namespace app\models;

use Yii;
use app\models\Person;

/**
 * This is the model class for table "auth".
 *
 * @property User $user
 */
class Auth extends User
{
    public $doc_status; // temp use
    public $allowPrint = false;
    public $sendEmail = false;
    public $password;
    public $send_welcome_email;
    public $new_password;
    public $send_password_update_notification;

    public static function tableName()
    {
        return 'auth';
    }

    public function rules()
    {
        return [
            [['id', 'username', 'auth_key', 'email'], 'required'],
            [['password', 'new_password', 'created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['username', 'password'], 'string', 'min' => 4, 'max' => 20],
            [['username', 'email'], 'string', 'max' => 140],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['status'], 'string'],
            ['email', 'email'],
            [['email','username'], 'unique'],
            [['email', 'username'], 'filter', 'filter' => 'trim'],
            // [['password_reset_token'], 'unique'], // require in reset only

            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_DELETED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['auth_id' => 'id']);
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, ['auth_id' => 'id']);
    }

    public function getStatusLabel()
    {
        if ($this->status == parent::STATUS_ACTIVE)
            $this->status = '<span class="ui mini green empty circular label"></span>&nbsp;' . Yii::t('app', 'Active');
        else
            $this->status = '<span class="ui mini red empty circular label"></span>&nbsp;' . Yii::t('app', 'Deleted');
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    public function lockUpdate()
    {
        return true;
    }

    public function lockDelete()
    {
        return true;
    }
}
