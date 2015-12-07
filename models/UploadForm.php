<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Document;
use app\models\Attachment;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;
    public $document_id;
    public $return_errors = [];

    public function rules()
    {
        return [
            [['document_id'], 'required'],
            [['document_id'], 'integer'],
            [['files'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 10],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->files as $file) {
                $attachment = new Attachment();
                $attachment->document_id = $this->document_id;
                $attachment->name = \Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $attachment->original_name = $file->baseName . '.' . $file->extension;
                $attachment->size = $file->size;
                if ($attachment->validate()) {
                    if ($file->saveAs(\Yii::$app->basePath . '/web/uploads/' . $attachment->name)) {
                        $attachment->save();
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
?>