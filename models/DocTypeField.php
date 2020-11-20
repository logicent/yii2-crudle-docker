<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_type_field".
 *
 * @property string $name
 * @property string $doc_type
 * @property string|null $label
 * @property int|null $length
 * @property string|null $type
 * @property string|null $options
 * @property int|null $mandatory
 * @property int|null $unique
 * @property int|null $in_list_view
 * @property int|null $in_standard_filter
 * @property int|null $in_global_search
 * @property int|null $bold
 * @property int|null $allow_in_quick_entry
 * @property int|null $translatable
 * @property int|null $fetch_from
 * @property int|null $fetch_if_empty
 * @property string|null $depends_on
 * @property int|null $ignore_user_permissions
 * @property int|null $allow_on_submit
 * @property int|null $report_hide
 * @property int|null $perm_level
 * @property int|null $hidden
 * @property int|null $readonly
 * @property string|null $mandatory_depends_on
 * @property string|null $readonly_depends_on
 * @property string|null $default
 * @property string|null $description
 * @property int|null $in_filter
 * @property int|null $print_hide
 * @property int|null $print_width
 * @property int|null $width
 */
class DocTypeField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_type_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'label', 'type', 'doc_type'], 'required'],
            [['length', 'mandatory', 'unique', 'in_list_view', 'in_standard_filter', 'in_global_search', 'bold', 'allow_in_quick_entry', 'translatable', 'fetch_from', 'fetch_if_empty', 'ignore_user_permissions', 'allow_on_submit', 'report_hide', 'perm_level', 'hidden', 'readonly', 'in_filter', 'print_hide', 'print_width', 'width'], 'integer'],
            [['options'], 'string'],
            [['name', 'doc_type', 'label', 'type', 'depends_on', 'mandatory_depends_on', 'readonly_depends_on', 'default', 'description'], 'string', 'max' => 140],
            [['name', 'doc_type'], 'unique', 'targetAttribute' => ['name', 'doc_type']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'doc_type' => Yii::t('app', 'Doc Type'),
            'label' => Yii::t('app', 'Label'),
            'length' => Yii::t('app', 'Length'),
            'type' => Yii::t('app', 'Type'),
            'options' => Yii::t('app', 'Options'),
            'mandatory' => Yii::t('app', 'Mandatory'),
            'unique' => Yii::t('app', 'Unique'),
            'in_list_view' => Yii::t('app', 'In List View'),
            'in_standard_filter' => Yii::t('app', 'In Standard Filter'),
            'in_global_search' => Yii::t('app', 'In Global Search'),
            'bold' => Yii::t('app', 'Bold'),
            'allow_in_quick_entry' => Yii::t('app', 'Allow In Quick Entry'),
            'translatable' => Yii::t('app', 'Translatable'),
            'fetch_from' => Yii::t('app', 'Fetch From'),
            'fetch_if_empty' => Yii::t('app', 'Fetch If Empty'),
            'depends_on' => Yii::t('app', 'Depends On'),
            'ignore_user_permissions' => Yii::t('app', 'Ignore User Permissions'),
            'allow_on_submit' => Yii::t('app', 'Allow On Submit'),
            'report_hide' => Yii::t('app', 'Report Hide'),
            'perm_level' => Yii::t('app', 'Perm Level'),
            'hidden' => Yii::t('app', 'Hidden'),
            'readonly' => Yii::t('app', 'Readonly'),
            'mandatory_depends_on' => Yii::t('app', 'Mandatory Depends On'),
            'readonly_depends_on' => Yii::t('app', 'Readonly Depends On'),
            'default' => Yii::t('app', 'Default'),
            'description' => Yii::t('app', 'Description'),
            'in_filter' => Yii::t('app', 'In Filter'),
            'print_hide' => Yii::t('app', 'Print Hide'),
            'print_width' => Yii::t('app', 'Print Width'),
            'width' => Yii::t('app', 'Width'),
        ];
    }
}
