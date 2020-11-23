<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\UploadedFile;

use app\models\Setup;

class OrgProfileForm extends Model
{
    public $name;
    public $short_name;
    public $location;
    public $contacts;
    public $logoPath;
    public $bgImagePath;

    public $who_we_are;
    public $history;
    public $vision;
    public $mission;
    public $values; // core_values
    public $theory_of_change;
    public $philosophy;
    public $thematic_focus; // focus_areas
    public $where_we_work;
    public $approaches;
    
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $uploadForm;

    public function init()
    {
        $this->uploadForm = new \app\models\forms\UploadForm();
    }

    public static function modelClass()
    {
        return 'OrgProfile';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [[
                'logoPath', 
                'bgImagePath', 
                'short_name', 
                'location', 
                'contacts', 
                'who_we_are',
                'history',
                'vision', 
                'mission', 
                'values', 
                'theory_of_change',
                'philosophy',
                'thematic_focus',
                'where_we_work',
                'approaches',
            ], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'short_name' => Yii::t('app', 'Short name'),
            'name' => Yii::t('app', 'Organization name'),
            'logoPath' => Yii::t('app', "Organization logo"),
            'bgImagePath' => Yii::t('app', "Background image"),
            'who_we_are' => Yii::t('app', 'Who we are'),
            'history' => Yii::t('app', 'History'),
            'vision' => Yii::t('app', 'Vision'),
            'mission' => Yii::t('app', 'Mission'),
            'values' => Yii::t('app', 'Values'),
            'theory_of_change' => Yii::t('app', 'Theory of Change'),
            'philosophy' => Yii::t('app', 'Philosophy'),
            'where_we_work' => Yii::t('app', 'Where we work'),
            'approaches' => Yii::t('app', 'Approaches'),
            'thematic_focus' => Yii::t('app', 'Thematic focus'),
            'location' => Yii::t('app', 'Physical address'),
            'contacts' => Yii::t('app', 'Contacts'),
        ];
    }

    public function save()
    {
        $fileObj = UploadedFile::getInstance($this->uploadForm, 'file_upload');
        
        if (!empty($fileObj))
        {
            $this->uploadForm->file_upload = $fileObj;
            $this->logoPath = $this->uploadForm->upload(); // if saveAs succeeded file_path is returned else false
        }

        foreach ($this->attributes as $attribute => $value)
        {
            if ($attribute == 'uploadForm')
                continue;
            
            $setup = Setup::findOne(['model' => self::modelClass(), 'attribute' => $attribute]);
            
            if (is_null($setup)) 
            {
                $setup = new Setup();
                $setup->model = self::modelClass();
                $setup->attribute = $attribute;

                if ($attribute == 'created_by')
                    $value = Yii::$app->user->id;

                if ($attribute == 'created_at')
                    $value = date(time());
            }
            else {
                if ($attribute == 'updated_by')
                    $value = Yii::$app->user->id;

                if ($attribute == 'updated_at')
                    $value = date(time());
            }

            $setup->value = $value; // is_array($value) ? implode(',', $value) : 
            // $setup->save(); // This does not work reliably

            Yii::$app->db
                ->createCommand()
                ->upsert(
                    Setup::tableName(),
                    $setup->attributes
                )
                ->execute();
        }

        // assumes success - to be improved
        return true;
    }
}
