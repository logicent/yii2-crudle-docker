<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;

class ReportBuilderForm extends Model
{
    public $source_table;
    public $join_tables;
    public $select_columns;
    public $where_filters;
    public $group_by_columns;
    public $having_filters;
    public $order_by_columns;

    public $system_tables = [
        'auth', 'auth_assignment', 'auth_item', 'auth_item_child', 'auth_rule',
        'email', 'file_info', 'help', 'i18n_message', 'i18n_source_message', 'i18n_timezone',
        'migration',
        'queue',
        'report',
        'settings',
        'user', 'people', 'todo'
    ];

    public $system_columns = [
        'comments'
    ];

    public $query_result;

    public function rules()
    {
        return [
            [['source_table'], 'required'],
            [['select_columns', 'where_filters', 'join_tables', 'group_by_columns', 'having_filters', 'order_by_columns'], 'safe'],
        ];
    }

    /**
     * @return array|false
     */
    public function getDbTableListOptions()
    {
        $all_tables = Yii::$app->db->schema->getTableNames();

        $db_tables = array_diff($all_tables, $this->system_tables);
        $db_tables = array_combine($db_tables, $db_tables);
        
        foreach ($db_tables as $db_table)
            $db_tables[$db_table] = Inflector::camel2words($db_table);

        $db_tables = ArrayHelper::merge(['' => ''], $db_tables);
        
        return $db_tables;
    }

    public function getDbTableColumnListOptions($table_name)
    {
        if (empty($table_name))
            return [];

        $table_schema = Yii::$app->db->getTableSchema($table_name);
        
        $columns = [];
        foreach ($table_schema->columns as $column)
        {
            if (in_array($column->name, $this->system_columns))
                continue;

            $columns[$column->name] = Inflector::camel2words($column->name);
        }

        return $columns;
    }

    public function getData( &$report )
    {
        if ($this->validate())
            return $report->query();

        return false;
    }
}
