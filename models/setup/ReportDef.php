<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ReportDef extends BaseActiveRecord
{

    public static function tableName()
    {
        return 'report';
    }

    public function rules()
    {
        $rules = parent::rules();

        return ArrayHelper::merge([
            [['name', 'module', 'type', 'source_table'], 'required'],
            [['module', 'is_standard', 'type', 'query_cmd', 'dataset', 'criteria', 'js_code', 'allow_roles'], 'string'],
            [['add_total_sums', 'use_permissions', 'hidden'], 'integer'],
            [['ref_code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 140],
            [['source_table'], 'string', 'max' => 100],
        ], $rules);
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'ref_code' => Yii::t('app', 'Ref Code'),
            'module' => Yii::t('app', 'Module'),
            'is_standard' => Yii::t('app', 'Is Standard'),
            'type' => Yii::t('app', 'Type'),
            'source_table' => Yii::t('app', 'Source'),
            'query_cmd' => Yii::t('app', 'Query'),
            'dataset' => Yii::t('app', 'Dataset'),
            'criteria' => Yii::t('app', 'Criteria'),
            'js_code' => Yii::t('app', 'JS Code'),
            'add_total_sums' => Yii::t('app', 'Add Total Sums'),
            'use_permissions' => Yii::t('app', 'Use Permissions'),
            'allow_roles' => Yii::t('app', 'Allow Roles'),
            'hidden' => Yii::t('app', 'Hidden'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->query_cmd = Json::encode($this->query_cmd);
            $this->dataset = Json::encode($this->dataset);
            $this->allow_roles = Json::encode($this->allow_roles);
            return true;
        }

        return false;
    }

    public function afterFind()
    {
        $this->query_cmd = Json::decode($this->query_cmd);
        $this->dataset = Json::decode($this->dataset);
        $this->allow_roles = Json::decode($this->allow_roles);
        return parent::afterFind();
    }
}
