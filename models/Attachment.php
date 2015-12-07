<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $original_name
 * @property integer $size
 * @property integer $document_id
 *
 * @property Document $document
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'original_name', 'size'], 'required'],
            [['size', 'document_id'], 'integer'],
            [['name', 'original_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'original_name' => 'Original Name',
            'size' => 'Size',
            'document_id' => 'Document ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }

    public function beforeDelete()
    {
        @unlink(Yii::$app->basePath . '/web/uploads/' . $this->name);

        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     * @return AttachmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AttachmentQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }
}
