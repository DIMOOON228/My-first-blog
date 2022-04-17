<?php

namespace frontend\controllers;

use common\models\Blog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BlogController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $blogs = Blog::find()->with('author')->orderBy('sort');
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination'=>[
                'pageSize'=>10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'id' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        return $this->render('all',compact('blogs','dataProvider'));
    }

    public function actionOne($url)
    {
       if($blog = Blog::find()->where(['url'=>$url])->one()) {
        return $this->render('one',compact('blog'));
       }
       throw new NotFoundHttpException('Ой, нету такого блога :(');
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
} 