<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

use app\models\Setup;

class IntegrationForm extends Model
{
    public $google_maps_api_key;

    public static function modelClass()
    {
        return 'Integration';
    }

    public function rules()
    {
        return [
            [['google_maps_api_key'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'google_maps_api_key' => Yii::t('app', 'Google Maps API Key'),
        ];
    }

    public function save()
    {
        foreach ($this->attributes as $attribute => $value)
        {
            $setup = Setup::findOne(['model' => self::modelClass(), 'attribute' => $attribute]);
            if (is_null($setup))
                $setup = new Setup();

            $setup->model = self::modelClass();
            $setup->attribute = $attribute;
            $setup->value = $value;
            $setup->save();
        }

        return;
    }
}
