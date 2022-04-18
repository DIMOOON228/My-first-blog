<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "image_manager".
 *
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $item_id
 * @property int $sort
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
            [['item_id','sort'], 'integer'],
            [['sort'],'default','value'=>function($model){
                $count=ImageManager::find()->where(['class'=>$model->class])->count();
                return ($count > 0)?$count++:0;
            }],
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
    public function getImageUrl(){
        if($this->name){
            $path =  str_replace('admin.','',Url::home(true)).'upload/images/'.$this->class.'/' .$this->name;
        }else{
            $path = str_replace('admin.','',Url::home(true)).'upload/images/noimage.svg';
        }

        return $path;
    }
    public function BeforeDelete(){
        if(parent::beforeDelete()){
            ImageManager::updateAllCounters(['sort'=>-1],['and',['class'=>'blog','item_id'=>$this->item_id],['>','sort',
                $this->sort]]);
            return true;
        }else{
            return 'Что-то пошло не по плану "Сэр"';
        }
    }
}
