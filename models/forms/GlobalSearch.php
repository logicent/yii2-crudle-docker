<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

class GlobalSearch extends Model
{
    public $gs_term;

    public function rules()
    {
        return [
            [['gs_term'], 'safe'],
        ];
    }

    public function get()
    {
        return;
    }
}
