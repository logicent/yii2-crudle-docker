<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     * @var UploadedFile[]
     */
    public $file_upload;
    public $file_uploads;

    public $model_classname;
    public $model_attribute;
    public $model_path;

    public function rules()
    {
        return [
            [['file_upload'], 'file', 'extensions' => [
                'jpg', 'png', 'gif', 'jpeg', 'svg',  // images
                'pdf', 'doc', 'xls', 'ppt', 'docx', 'xlsx', 'pptx',  // office documents
                'csv', 'txt',   // plain text
                'wav', 'mp3',   // audio
                'avi', 'mp4',   // video
                ], 'skipOnEmpty' => true // , 'maxSize' => 1024*1024
            ],
            [['file_uploads'], 'file', 'extensions' => [
                'jpg', 'png', 'gif', 'jpeg', 'svg',  // images
                'pdf', 'doc', 'xls', 'ppt', 'docx', 'xlsx', 'pptx',  // office documents
                'csv', 'txt',   // plain text
                'wav', 'mp3',   // audio
                'avi', 'mp4',   // video
                ], 'skipOnEmpty' => true, 'maxFiles' => 20 // , 'maxSize' => 1024*1024
            ],
        ];
    }

    public function upload()
    {
        if ($this->validate())
        {
            // $file_path = $this->file_upload->baseName . '.' . $this->file_upload->extension;
            $file_path = $this->file_upload->name;
            $this->file_upload->saveAs(Yii::getAlias('@webroot/') . 'uploads/' . $file_path);

            return $file_path;
        }
        // else
        return false;
    }

    public function uploads()
    {
        // if ($this->validate()) {
            $file_paths = '';
            foreach ($this->file_uploads as $file) {
                if (!empty($file_paths))
                    $file_paths .= ',';
                $file_path = $file->baseName . '.' . $file->extension;
                $file->saveAs(Yii::getAlias('@webroot/') . 'uploads/' . $file_path);

                $file_paths .= $file_path;
            }
            return $file_paths;
        // }

        // else
        return false;
    }
}
