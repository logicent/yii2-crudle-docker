<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

use app\models\Setup;

class ReportingForm extends Model
{
    public static function modelClass()
    {
        return 'Reporting';
    }
    
    public function rules()
    {
        return [
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
