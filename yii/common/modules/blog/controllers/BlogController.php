<?php

namespace common\modules\blog\controllers;


use common\modules\blog\models\BlogSearch;
use common\models\ImageManager;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-image' => ['POST'],
                        'sort-image' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Blog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    // public function actionDima()
    // {
    //     for($i=0;$i<30;$i++){
    //         $model = new Blog();
    //         $model->title = 'Заголовок №'.$i;
    //         $model->sort = 50;
    //         $model->status_id = 1;
    //         $model->url = 'url_'.$i;
    //         $model->save();
    //     }
    //     return 'Я все сделал';
    // }

    /**
     * Displays a single Blog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new \common\modules\blog\models\Blog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \common\modules\blog\models\Blog::find()->with('tags')->where(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeleteImage(){
        if (($model = ImageManager::findOne(Yii::$app->request->post('key')))and $model->delete()) {
            return true;
        }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    public function actionSortImage($id){
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post('sort');
            if($post['oldIndex'] >  $post['newIndex']){
                $param = ['and',['>=','sort',$post['newIndex']],['<','sort',$post['oldIndex']]];
                $counter = 1;
            }else{
                $param = ['and',['<=','sort',$post['newIndex']],['>','sort',$post['oldIndex']]];
                $counter = -1;
            }
            ImageManager::updateAllCounters(['sort'=>$counter],['and',['class'=>'blog','item_id'=>$id],$param]);
            ImageManager::updateAll(['sort'=>$post['newIndex']],['id'=>$post['stack'[$post['newIndex']]]['key']]);
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }
    }


