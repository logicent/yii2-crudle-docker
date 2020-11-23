<?php

namespace app\models;

use Yii;
use yii\helpers\Json;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property Auth $auth
 */
class Person extends BaseActiveRecord
{
    public $id; // i.e. auth_id PK/FK
    public $full_name;
    public $old_role;
    public $uploadForm;
    public $myAccountRoute;
    public $myAccountRouteParam;
    public $myAccountRouteParamValue;
    public $teammateIds;

    // Official Status: 'On Duty','Out of Office','On Study Leave'
    // System Roles: 'Guest User','Basic User','System Manager','Administrator'

    public function init()
    {
        $this->uploadForm = new forms\UploadForm();
    }

    public static function tableName()
    {
        return 'user';
    }

    // public static function primaryKey()
    // {
    //     return ['auth_id'];
    // }

    public function rules()
    {
        return [
            [['auth_id', 'role', 'firstname', 'surname'], 'required'],
            [['sex', 'official_status', 'additional_info', 'job_history'], 'string'],
            [['role', 'birth_date', 'last_login_at', 'logged_on'], 'safe'],
            [['auth_id', 'reports_to', 'mobile_no'], 'string', 'max' => 20],
            [['google_token_id'], 'string', 'max' => 200],
            [['designation', 'firstname', 'surname'], 'string', 'max' => 50],
            [['mailing_address', 'avatar'], 'string', 'max' => 140],
            [['last_login_ip'], 'string', 'max' => 128],
            [['firstname', 'surname', 'google_token_id'], 'filter', 'filter' => 'trim'],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::class, 'targetAttribute' => ['auth_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'auth_id' => Yii::t('app', 'Auth ID'),
            'google_token_id' => Yii::t('app', 'Google Token ID'),  // OAuth Provider
            'role' => Yii::t('app', 'Role'),
            'designation' => Yii::t('app', 'Designation'),
            'firstname' => Yii::t('app', 'Firstname'),
            'surname' => Yii::t('app', 'Surname'),
            'sex' => Yii::t('app', 'Sex'),
            'birth_date' => Yii::t('app', 'Date of Birth'),
            'mailing_address' => Yii::t('app', 'Mailing Address'),
            'mobile_no' => Yii::t('app', 'Mobile No'),
            'reports_to' => Yii::t('app', 'Reports To'),
            'official_status' => Yii::t('app', 'Official Status'),
            'avatar' => Yii::t('app', 'Avatar'),
	// Timezone
            'additional_info' => Yii::t('app', 'Additional Info'),
            'job_history' => Yii::t('app', 'Job History'),
            'last_login_ip' => Yii::t('app', 'Last Login IP'),
            'last_login_at' => Yii::t('app', 'Last Login At'),
            'logged_on' => Yii::t('app', 'Logged On'),
	// 2FA enabled,	Twofa Secret, Twofa Timestamp
        ];
    }

    public function getAuth()
    {
        return $this->hasOne(Auth::class, ['id' => 'auth_id']);
    }

    public static function getUserFullNameById($auth_id)
    {
        return self::findOne($auth_id)->full_name;
    }

    public function getPartner()
    {
        return null;
    }

    public function getRoles()
    {
        $all_roles = setup\auth\Item::find()->select(['name'])->where(['type' => 1]);

        if (
            !Yii::$app->user->can('Administrator') &&
            !Yii::$app->user->can('System Manager')
        )
            $all_roles->andWhere(['<>', 'name', 'Administrator']);

        return $all_roles->asArray()->all();

        // Use this when user-defined role are suppported

        return (new Query())
            ->select(['name', 'description'])
            ->from('auth_item')
            ->where(['and', 'type=1',
                ['not like', 'name', 'Administrator'] // hide Administrator role
            ])
            ->all();
    }

    public function getRoleByUserId($user_id)
    {
        return setup\auth\Assignment::find()->select(['item_name'])->where(['user_id' => $user_id])->scalar();
    }

    public static function getRolesByName()
    {
        return setup\auth\Item::find()->select(['name'])->where(['type' => 1])->asArray()->all();
    }

    public function getTeammateIds()
    {
        $teammateIds = [];
        
        if (!empty($this->reports_to))
        {
            $teammateIds = self::find()->where(['in', 'reports_to', $this->reports_to])->column();

            array_push($teammateIds, $this->reports_to);
        }

        return $teammateIds;
    }

    public function afterFind()
    {
        $this->id = $this->auth_id; // Comments layout partial expects id attribute

        $this->full_name = $this->firstname . ' ' . $this->surname;

        $myRouteAction = Yii::$app->user->can('System Manager') || Yii::$app->user->can('Administrator') ? 'update' : 'view';
        
        if ($myRouteAction == 'view')
        {
            $this->myAccountRouteParam = 'email';
            $this->myAccountRouteParamValue = Yii::$app->user->identity->email;
        }
        else {
            $this->myAccountRouteParam = 'id';
            $this->myAccountRouteParamValue = Yii::$app->user->id;
        }

        $this->myAccountRoute = 'user/' . $myRouteAction;
        
        return parent::afterFind();
    }

    // public function beforeValidate()
    // {
    //     if (is_array($this->role))
    //         $this->role = implode($this->role);
        
    //     return parent::beforeValidate();
    // }

    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert))
    //     {
    //         return true;
    //     }
    //     return false;
    // }

}
