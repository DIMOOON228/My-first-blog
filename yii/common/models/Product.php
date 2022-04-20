<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property int|null $cost
 * @property int $type_id
 * @property string|null $text
 * @property int|null $sklad_id
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type_id'], 'required'],
            [['cost', 'type_id', 'sklad_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'cost' => 'Cost',
            'type_id' => 'Type ID',
            'text' => 'Text',
            'sklad_id' => 'Sklad ID',
        ];
    }
    public static function getTypeList(){
        return [
            'первый','втовой','третий'
        ];
    }
    public function  getSklad(){
        return $this->hasOne(Sklad::className(),['id'=>'sklad_id']);
    }

    public function  getSkladName(){
        return (isset($this->sklad))?$this->sklad->title:'Склад был удален или закрыт :(' ;
    }

    public function  getTypeName(){
        $list = $this->getTypeList();
        return $list[$this->type_id];
    }
}
