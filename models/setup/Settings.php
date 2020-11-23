<?php

namespace app\models\setup;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

class Settings extends \app\models\BaseActiveRecord
{
    public static function tableName()
    {
        return 'settings';
    }

    public static function primaryKey()
    {
        return ['model_name', 'attribute_name'];
    }

    public function rules()
    {
        return [
            [['model_name', 'attribute_name'], 'required'],
            [['description', 'attribute_value', 'validation_rule', 'type', 'comments'], 'string'],
            ['hidden', 'boolean'],
            [['model_name', 'attribute_name', 'default_value', 'form_title', 
                'attribute_label'], 'string', 'max' => 140],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 140],
        ];
    }

    public function attributeLabels()
    {
        return [
            'model_name' => Yii::t('app', 'Model Name'),
            'attribute_name' => Yii::t('app', 'Attribute Name'),
            'attribute_value' => Yii::t('app', 'Attribute Value'),
            'attribute_label' => Yii::t('app', 'Attribute Label'),
            'validation_rule' => Yii::t('app', 'Validation Rule'),
            'default_value' => Yii::t('app', 'Default Value'),
            'form_title' => Yii::t('app', 'Form Title'),
            'description' => Yii::t('app', 'Description'),
            'hidden' => Yii::t('app', 'Hidden'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_ay' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'comments' => Yii::t('app', 'Comments'),
        ];
    }

    public function getSettings($modelClass)
    {
        $modelClassname = '\app\models\setup\\' . $modelClass . 'Form';
        $model = new $modelClassname();

        $settings = self::find()->where(['model_name' => $modelClass])->asArray()->all();
        if (empty($settings))
            return $model;

        foreach ($settings as $setting)
            $model->{$setting['attribute_name']} = $setting['attribute_value'];

        return $model;
    }

}
