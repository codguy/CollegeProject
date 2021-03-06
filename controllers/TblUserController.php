<?php

namespace app\controllers;

use app\models\TblUser;
use app\models\search\TblUser as TblUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\LoginForm;

/**
 * TblUserController implements the CRUD actions for TblUser model.
 */
class TblUserController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TblUser models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblUserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblUser model.
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
     * Creates a new TblUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblUser();
        $obj = rand(100,999);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                print_r($model);die;
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by_id = '1';
                $model->authKey = 'test'.$obj.'.key';
                $model->accessToken = $obj.'-token';
                $model->profile_picture = UploadedFile::getInstance($model, 'profile_picture');
                $model->upload();
                if ($model->save(false)) {
                    $this->redirect([
                        'index'
                    ]);
                }
                
            }
        } else {
            $model->loadDefaultValues();
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }
    
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        $model->password = '';
        return $this->render('../site/login', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($this->request->isPost && $model->load($this->request->post())){
            $model->profile_picture = UploadedFile::getInstance($model, 'profile_picture');
            $model->upload();
            $model->profile_picture = $model->imageName();
            
            //             echo '<pre>';var_dump($model);die;
            if($model->save(false)) {
                
                return $this->redirect([
                    'view',
                    'id' => $model->id
                ]);
            }
            
        }
        
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing TblUser model.
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
     * Finds the TblUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TblUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TblUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
