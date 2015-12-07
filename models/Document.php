<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%document}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    public function beforeDelete()
    {
        foreach ($this->attachments as $attachment) {
            $attachment->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     * @return DocumentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentQuery(get_called_class());
    }

    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['document_id' => 'id']);
    }
}
