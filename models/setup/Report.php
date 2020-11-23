<?php

namespace app\models\setup;

use app\models\BaseActiveRecord;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;

class Report extends BaseActiveRecord
{
    public $hasWorkflow = false;

    public function behaviors()
    {
        $behaviors = parent::rules();

        return ArrayHelper::merge([
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'code',
                // 'slugAttribute' => 'slug',
            ],
        ], $behaviors);
    }

    public static function tableName()
    {
        return 'report';
    }

    public function rules()
    {
        return [
            [['code', 'name', 'query_cmd'], 'required'],
            [['type', 'query_cmd', 'dataset', 'criteria', 'js_code', 'allow_roles', 'comments'], 'string'],
            [['add_sum_total', 'use_permissions', 'hidden'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'created_by', 'updated_by'], 'string', 'max' => 20],
            [['name', 'module'], 'string', 'max' => 140],
            [['code'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'module' => 'Module',
            'type' => 'Type',
            'query_cmd' => 'Query',
            'dataset' => 'Dataset',
            'criteria' => 'Criteria',
            'js_code' => 'Js Code',
            'add_sum_total' => 'Add Sum Total',
            'use_permissions' => 'Use Permissions',
            'allow_roles' => 'Allow Roles',
            'hidden' => 'Hidden',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'comments' => 'Comments',
        ];
    }

    public static function getListOptions($pk = 'code', $filters = [])
    {
        // $iterator = new GlobIterator(Yii::getAlias('@app/models/*/*/*'));

        // $filelist = [];
        // foreach($iterator as $entry) {
        //     if (name has Search or Form ignore)
        //     if (isfolder)
        //     $filelist[] = $entry->getBasename('.php');
        // }
        // ddd($filelist);
        return [
            '' => '',
            'Contract' => 'Contract',
            'Grant' => 'Grant',
            'Work Plan' => 'Work Plan',
            // '\app\models\activity\Activity' => 'Activity',
            'Event' => 'Event',
            'Operations' => 'Operations',
            'Grants' => 'Grants',
        ];
    }

    public function lockUpdate()
    {
        return !Yii::$app->user->can('Update Report');
    }

    // public function lockDelete()
    // {
    //     return !Yii::$app->user->can('Delete Report');
    // }

}
