<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use app\models\Setup;

class DeveloperForm extends Model
{
    public $endUserLicense; // Terms of Use, Privacy Policy, End-User License Agreement
    public $endUserRef;     // Sales Invoice Ref
    public $licenseValidFrom;
    public $licenseValidTo;
    public $userLimit = 0; // 0 is default i.e. none
    public $enableDAIntegration = false; // Web-based data analytics enabled
    public $enableDCIntegration = false; // Mobile-device data collection enabled

    public static function modelClass()
    {
        return 'Developer';
    }

    public function rules()
    {
        return [
            [['endUserLicense', 'endUserRef', 'licenseValidFrom', 'licenseValidTo'], 'required'],
            [['userLimit', 'enableDCIntegration'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'endUserLicense' => Yii::t('app', 'End user license'),
            'endUserRef' => Yii::t('app', 'End user ref.'),
            'licenseValidFrom' => Yii::t('app', 'License valid from'),
            'licenseValidTo' => Yii::t('app', 'License valid to'),
            'userLimit' => Yii::t('app', 'USer limit'),
            'enableDAIntegration' => Yii::t('app', 'Enable Data Analytics integration'),
            'enableDCIntegration' => Yii::t('app', 'Enable Data Collection integration'),
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
