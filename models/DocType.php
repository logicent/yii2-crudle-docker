<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_type".
 *
 * @property string $name
 * @property string $module
 * @property string|null $title_field
 * @property string|null $image_field
 * @property int|null $max_attachments
 * @property int|null $hide_copy
 * @property int|null $is_table
 * @property int|null $quick_entry
 * @property int|null $track_changes
 * @property int|null $track_views
 * @property int|null $allow_auto_repeat
 * @property int|null $allow_import
 * @property string|null $search_fields
 * @property string|null $sort_field
 * @property string|null $sort_order
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class DocType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'module'], 'required'],
            [['max_attachments', 'hide_copy', 'is_table', 'quick_entry', 'track_changes', 'track_views', 'allow_auto_repeat', 'allow_import'], 'integer'],
            [['search_fields'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'module', 'title_field', 'image_field', 'sort_field', 'sort_order', 'created_by', 'updated_by'], 'string', 'max' => 140],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'module' => Yii::t('app', 'Module'),
            'title_field' => Yii::t('app', 'Title Field'),
            'image_field' => Yii::t('app', 'Image Field'),
            'max_attachments' => Yii::t('app', 'Max Attachments'),
            'hide_copy' => Yii::t('app', 'Hide Copy'),
            'is_table' => Yii::t('app', 'Is Table'),
            'quick_entry' => Yii::t('app', 'Quick Entry'),
            'track_changes' => Yii::t('app', 'Track Changes'),
            'track_views' => Yii::t('app', 'Track Views'),
            'allow_auto_repeat' => Yii::t('app', 'Allow Auto Repeat'),
            'allow_import' => Yii::t('app', 'Allow Import'),
            'search_fields' => Yii::t('app', 'Search Fields'),
            'sort_field' => Yii::t('app', 'Sort Field'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
        ];
    }
}
