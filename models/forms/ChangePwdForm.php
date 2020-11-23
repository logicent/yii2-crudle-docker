<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

use app\models\Auth;

/**
 * ChangePwdForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangePwdForm extends Model
{
    public $new_password;
    public $send_password_update_notification = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['new_password'], 'required'],
            ['send_password_update_notification', 'boolean'],
        ];
    }
}
