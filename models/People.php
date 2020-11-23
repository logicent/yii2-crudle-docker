<?php

namespace app\models;

use Yii;
// use yii\helpers\ArrayHelper;
// use app\models\Partner;

/**
 * This is the model class for table "user".
 *
 * @property Auth $auth
 */
class People extends Person
{
    const DESIGNATION_ORG_USER = 'Org Staff';
    const DESIGNATION_FP_USER = 'Donor Staff';
    const DESIGNATION_IP_USER = 'IP Staff';
    // const DESIGNATION_BP_USER = 'Beneficiary User';

    public static function tableName()
    {
        return 'people';
    }

    // public function getReportData($columns = '*')
    // {
    //     $columnSchema = parent::dbTableSchema()->columns;

    //     $rows = parent::getReportData($columns)->where(['status' => 1]);

    //     $rows = $rows->all();

    //     return $rows;
    // }

    public function getPeople()
    {
        return Person::find()->all();
    }

    // public function getPartner()
    // {
    //     return null;
    // }

    public static function getAllListOptions($pk = 'auth_id', $filters = [])
    {
        return self::find()->select([$pk, 'CONCAT(firstname," ",surname) as fullname'])
            ->where(['status' => User::STATUS_ACTIVE])
            // ->andWhere(['in', 'designation', [self::DESIGNATION_ORG_USER]])
            ->orderBy('fullname')
            ->asArray()
            ->all();
    }

    public static function getListOptions($key = 'auth_id', $value = '', $filters = [])
    {
        return self::find()->select([$key, 'CONCAT(firstname," ",surname) as fullname'])
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->andWhere(['in', 'designation', [self::DESIGNATION_ORG_USER]])
                    ->orderBy('fullname')
                    ->asArray()
                    ->all();
    }

    public static function getListNames($staff_ids, $raw = false)
    {
        if (empty($staff_ids))
            $staff_ids = [];

        $people = self::find()->select('fullname')->where(['in', 'auth_id', $staff_ids])->column();

        $list_names = '';

        foreach ($people as $person)
            $raw ? $list_names .= $person . ', ' : $list_names .= '<a class="item">' . $person . '</a>';
        return $list_names;
    }

    public static function getListItemDetail($staff_ids)
    {
        if (empty($staff_ids))
            $staff_ids = [];

        $people = self::find()->where(['in', 'id', $staff_ids])->all();

        $list_names = '<tbody>';

        foreach ($people as $person)
            $list_names .=
                "<tr>
                <td class='text-muted'>Name of Consultant (as per ID/Passport):</td>
                    <td>{$person->fullname}</td>
                </tr>
                <tr>
                    <td class='text-muted'>Mobile Number:</td>
                        <td>{$person->mobile_no}</td>
                </tr>
                <tr>                    
                    <td class='text-muted'>Email address:</td>
                        <td>{$person->email}</td>
                </tr>
                <tr>
                    <td class='text-muted'>ID Number (required by some airlines):</td>
                        <td>{$person->additional_info}</td>
                </tr>
            ";
        /*
        <tr>
            <td class='text-muted'>Does s/he have a contract? (Yes/No) <br>
                <small>if no, liaise with HR as travel plans will be affected.</small></td>
                <td>{$person->contractCount}</td>
        </tr>
        */
        return $list_names . '</tbody>';
    }

    public function getOrgListByCurrentUser($columns = 'auth_id')
    {
        $current_user = Yii::$app->user->identity->person;

        return self::find()->select($columns)
                            ->where(['designation' => $current_user->designation])
                            ->asArray()
                            ->all();
    }
}
