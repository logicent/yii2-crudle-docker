<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "settings".
 *
 * @property string $model
 * @property string $attribute
 * @property string $value
 */
class Setup extends ActiveRecord
{
    public static function tableName()
    {
        return 'settings';
    }

    public function rules()
    {
        return [
            [['model', 'attribute'], 'required'],
            [['model', 'attribute', 'value'], 'string', 'max' => 40],
        ];
    }

    public function attributeLabels()
    {
        return [
            'model' => Yii::t('app', 'Model'),
            'attribute' => Yii::t('app', 'Attribute'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    public static function getSettings($modelClass)
    {
        $modelClassname = '\app\models\setup\\' . $modelClass . 'Form';
        $model = new $modelClassname();

        $settings = Setup::find()->where(['model' => $modelClass])->asArray()->all();
        if (empty($settings))
            return $model;

        foreach ($settings as $setting)
            $model->{$setting['attribute']} = $setting['value'];

        return $model;
    }

}
