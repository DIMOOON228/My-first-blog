<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "image_manager".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $item_id
 */
class ImageManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_manager';
    }
    public $attachment;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'class', 'item_id',], 'required'],
            [['item_id'], 'integer'],
            [['name', 'class','alt'], 'string', 'max' => 150],
            [['attachment'], 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'class' => 'Class',
            'item_id' => 'Item ID',
            'alt' => 'Alt'
        ];
    }
}
