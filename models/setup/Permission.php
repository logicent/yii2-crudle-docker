<?php

namespace app\models\setup;

use Yii;
use yii\helpers\ArrayHelper;

class Permission extends auth\Item
{
    public $hasWorkflow = false;
    public $allowPrint = false;
    public $display_name;
    
    public function init()
    {
        $this->type = parent::TYPE_PERMISSION;
    }

    public function getAuthItemAttributes()
    {
        return parent::attributes();
    }

    public function getValueIf($permission, $role)
    {
        return auth\ItemChild::find()->where(['child' => $permission, 'parent' => $role])->exists();
    }

    public function getHiddenPermission()
    {
        
    }

    public function getPermissionAssignee()
    {

    }

    public function afterFind()
    {
        // reverse word to display for easier reading
        $word_array = str_word_count( $this->name, 1 );
        $reverse_word = array_reverse( $word_array );
        $this->display_name = implode( ' ', $reverse_word );
    }

    // Standard Permission
    // -------------------
    // CREATE
    // LIST
    // READ
    // UPDATE
    // DELETE
    // REPORT
    // *PAGE
}