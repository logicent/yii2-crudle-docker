<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;

use app\models\Setup;

class SmtpForm extends Model
{
    public $smtp_host;
    public $from_address;
    public $from_name;
    public $smtp_username;
    public $smtp_password;
    public $smtp_port;
    public $smtp_encryption;
    public $smtp_timeout;
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;

    public static function modelClass()
    {
        return 'Smtp';
    }

    public function rules()
    {
        return [
            [['smtp_host', 'smtp_username', 'smtp_password', 'smtp_port'], 'required'],
            [['from_address'], 'email'],
            [['from_address', 'from_name', 'smtp_encryption'], 'string'],
            [['smtp_port', 'smtp_timeout'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'smtp_host' => Yii::t('app', 'Host'),
            'from_address' => Yii::t('app', 'From address'),
            'from_name' => Yii::t('app', "From name"),
            'smtp_username' => Yii::t('app', "Username"),
            'smtp_password' => Yii::t('app', "Password"),
            'smtp_port' => Yii::t('app', 'Port'),
            'smtp_encryption' => Yii::t('app', 'Encryption'),
            'smtp_timeout' => Yii::t('app', 'Timeout'),
        ];
    }

    public function save()
    {
        foreach ($this->attributes as $attribute => $value)
        {
            $setup = Setup::findOne(['model' => self::modelClass(), 'attribute' => $attribute]);

            if (is_null($setup)) 
            {
                $setup = new Setup();
                $setup->model = self::modelClass();
                $setup->attribute = $attribute;

                if ($attribute == 'created_by')
                    $value = Yii::$app->user->id;

                if ($attribute == 'created_at')
                    $value = date(time());
            }
            else {
                if ($attribute == 'updated_by')
                    $value = Yii::$app->user->id;

                if ($attribute == 'updated_at')
                    $value = date(time());
            }

            $setup->value = $value; // is_array($value) ? implode(',', $value) : 
            // $setup->save(); // This does not work reliably

            Yii::$app->db
                ->createCommand()
                ->upsert(
                    Setup::tableName(),
                    $setup->attributes
                )
                ->execute();
        }

        return;
    }
}
