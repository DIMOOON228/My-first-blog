<?php

namespace common\models;
use yii\image\ImageDriver;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string $url
 * @property int $status_id
 * @property int $sort
 * @property int $date_create
 * @property int $date_update
 * @property int $image
 */
class Blog extends \yii\db\ActiveRecord
{
    public $tags_array;
    public $file; 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['text'], 'string'],
            [['url'], 'unique'],//уникальность урла )
            [['sort'], 'integer','max'=>99,'min'=>1],
            [['status_id', 'sort'], 'integer'],
            [['title', 'url'], 'string', 'max' => 250],
            [['image'], 'string', 'max' => 100],
            [['file'],'image'],
            [['tags_array','date_create','date_update' ], 'safe'],
        ];
    }
    public function behaviors()
    {
        return [
            'timestampBehavior'=>[
                'class' => TimestampBehavior::classname(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
                'value' => new Expression('NOW()'),
            ]
            ,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'url' => 'Url',
            'status_id' => 'Статус',
            'tags'=>'Тэги',
            'tags_array'=>'Тэги',
            'sort' => 'Сортировка',
            'author.username'=>'Автор',
            'author.email'=>'Email автора ',
            'tagsAsSting' =>'Тэги',
            'date_update'=>'Дата обновления',
            'date_create'=>'Дата создания',
            'image'=>'Картинка',
            'file'=>'Картинка',
        ];
    }
    public static function getStatusList(){
        return ['Off','On','In processing'];
    }
    public function getStatusName(){
        $list = self::getStatusList();
        return $list[$this->status_id];
    }

    public function getAuthor(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }
    public function getBlogTag(){
        return $this->hasMany(BlogTag::className(),['blog_id'=>'id']);
    }

    public function getTags(){
        return $this->hasMany(Tag::className(),['id'=>'tag_id'])->via('blogTag');
    }
    public function getSmallImage(){
        if($this->image){
            $path =  str_replace('admin.','',Url::home(true)).'upload/images/blog/50x50/'.$this->image;
        }else{
            $path = str_replace('admin.','',Url::home(true)).'upload/images/noimage.svg';
        }
        
        return $path;
    }
    public function afterFind()
    {
        $this->tags_array = $this->tags;
    }
    public function afterSave($insert,$changgeAttributes)
    {
        parent::afterSave($insert,$changgeAttributes);
        $arr = ArrayHelper::map($this->tags,'id','id');
        if($this->tags_array){
            foreach($this->tags_array as $one){
            if(!in_array($one,$arr)){
                $model = new BlogTag();
                $model->blog_id=$this->id;
                $model->tag_id= $one;
                $model->save();
            }
            if (isset($arr[$one])){
                unset($arr[$one]);
            }
        }
    }
        BlogTag::deleteAll(['tag_id'=>$arr,'blog_id'=>$this->id]);
    }
    public function getTagsAsSting()
    {
        $arr = ArrayHelper::map($this->tags,'id','name');
        return implode(', ',$arr);
    }
        public function beforeSave($insert)
    {
        if ($file = UploadedFile::getInstance($this, 'file')){
            $dir = Yii::getAlias('@images')."/blog/";
            if(!empty($this->image)){
            if(file_exists($dir.$this->image)){
                unlink($dir.$this->image);
            }
            if(file_exists($dir.'50x50/'.$this->image)){
                unlink($dir.'50x50/'.$this->image);
            }
            if(file_exists($dir.'800x/'.$this->image)){
                unlink($dir.'800x/'.$this->image);
            }
        }
            $this->image = strtotime('now').'_'. Yii::$app->getSecurity()->generateRandomString(7).'.'.$file->extension;
            $file->saveAs($dir.$this->image);
            $imag = Yii::$app->image->load($dir.$this->image);
            $imag->background('#fff',0);
            $imag->resize('100','100',yii\image\drivers\Image::INVERSE);
            $imag->crop('100','100');
            $imag->save($dir.'50x50/'.$this->image,100);
            $imag = Yii::$app->image->load($dir.$this->image);
            $imag->background('#fff',0);
            $imag->resize('800',null,yii\image\drivers\Image::INVERSE);
            $imag->save($dir.'800x/'.$this->image,100);
        }
        return parent::beforeSave($insert);
    }
}

