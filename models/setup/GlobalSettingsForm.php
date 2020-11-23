<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

use app\models\Setup;

class GlobalSettingsForm extends Model
{
    public $defaultLanguage = 'en';
    public $defaultTimeZone = 'Africa/Nairobi';
    public $defaultTimeFormat = 'HH:mm';
    public $defaultDateFormat = 'yyyy/mm/dd';
    public $defaultCountryMap = '{lat: -0.023559, lng: 37.90619300000003}';
    public $firstDayOfWeek = 'Sun';
    
    public static function modelClass()
    {
        return 'Global';
    }

    public function rules()
    {
        return [
            [['defaultLanguage', 'defaultTimeFormat', 'defaultDateFormat', 'defaultCountryMap'], 'safe'],
        ];
    }

    public function save()
    {
        foreach ($this->attributes as $attribute => $value)
        {
            $setup = Setup::findOne(['model' => self::modelClass(), 'attribute' => $attribute]);
            if (is_null($setup))
                $setup = new Setup();

            $setup->model_name = self::modelClass();
            $setup->attribute_name = $attribute;
            $setup->attribute_value = $value;
            $setup->save();
        }

        return;
    }
}
