<?php

namespace app\models\setup;

use Yii;

class Role extends auth\Item
{
    public $hasWorkflow = false;
    public $allowPrint = false;

    public $permissions;

    public function init()
    {
        $this->permissions = 
            Permission::find()
                        ->where(['type' => 2, 'rule_name' => null])
                        ->andWhere(['not like', 'name', 'Approve'])
                        ->andWhere(['not like', 'name', 'Cancel'])
                        ->andWhere(['not like', 'name', 'Close'])
                        ->andWhere(['not like', 'name', 'List'])
                        ->andWhere(['not like', 'name', 'Read'])
                        ->orderBy('name DESC')
                        ->all();
    }

    public function getRoleAssignee()
    {
        return auth\Assignment::find()->select('user_id')->where(['item_name' => $this->name])->column();
    }

    public function hasPermissions()
    {
        return auth\ItemChild::find()->where(['parent' => $this->name])->count() > 0;
    }

    public function getAssignedPermissions()
    {
        return auth\ItemChild::find()->select('child')->where(['parent' => $this->name])->column();
    }

    public function hasThisPermission($permission, $role)
    {
        return auth\ItemChild::find()->where(['child' => $permission, 'parent' => $role])->exists();
    }

    public function hasRule()
    {
        return auth\Rule::find()->where(['name' => 'is' . $this->name])->count() > 0;
    }

    public function getRules()
    {
        return auth\Rule::find()->where(['name' => 'is' . $this->name])->all();
    }

    // User Type
    // ---------
    // Guest User i.e. external user NOT on <b>@yourdomain.com</b>
    // Standard User i.e. internal user on <b>@yourdomain.com</b>
    // System Manager i.e. internal system administrator
    // Administrator i.e. developer (hidden account)

    // Custom Roles
    // ------------
    // Additional roles that may be defined by System Manager
    // e.g. Enumerator

}
