<?php

namespace app\controllers;

use app\models\TblUser;
use app\models\search\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\LoginForm;
use app\models\Notification;


/**
 * UserController implements the CRUD actions for TblUser model.
 */
class UserController extends Controller
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
        $searchModel = new User();
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
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by_id = '1';
                $model->state_id = TblUser::STATE_ACTIVE;
                $model->authKey = 'test'.$obj.'.key';
                $model->accessToken = $obj.'-token';
                $model->profile_picture = UploadedFile::getInstance($model, 'profile_picture');
                $model->upload();
                if ($model->save(false)) {
                    $title = 'New '.$model->getRole($model->roll_id);
                    $type = Notification::TYPE_NEW_USER;
                    $notification = new Notification();
                    $notification->username = $model->username;
                    $notification->title = $title;
                    $notification->type_id = $type;
                    $notification->user_id = $model->id;
                    $notification->icon_name = 'user';
                    $notification->state_id = Notification::STATE_UNREAD;
                    $notification->model_id = get_class($model);
                    $notification->created_on = date('Y-m-d H:i:s');
                    $notification->created_by_id = '1';
                    $notification->save(false); 
                    $this->redirect([
                        'view',
                        'id' => $model->id
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
    
    public function actionSignup()
    {
        $this->layout = 'blank';
        $model = new TblUser();
        $obj = rand(100,999);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
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
            
            //             echo '<pre>';var_dump($model);die;
            if($model->save(false)) {
                $title = 'Update';
                $type = Notification::TYPE_USER_UPDATED;
                $users = TblUser::findAll(['roll_id' => TblUser::ROLE_ADMIN]);
                foreach ($users as $user){
                    $notification = new Notification();
                    $notification->username = $model->username;
                    $notification->title = $title;
                    $notification->type_id = $type;
                    $notification->user_id = $model->id;
                    $notification->icon_name = 'user';
                    $notification->to_user_id = $user->id;
                    $notification->state_id = Notification::STATE_UNREAD;
                    $notification->model_id = get_class($model);
                    $notification->created_on = date('Y-m-d H:i:s');
                    $notification->created_by_id = '1';
                    $notification->save(false);
                }
                
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
        $model = $this->findModel($id);
        $title = 'Deleted';
        $type = Notification::TYPE_USER_DELETED;
        $notification = new Notification();
        $notification->username = $model->username;
        $notification->title = $title;
        $notification->type_id = $type;
        $notification->user_id = $model->id;
        $notification->icon_name = 'user';
        $notification->state_id = Notification::STATE_UNREAD;
        $notification->model_id = get_class($model);
        $notification->created_on = date('Y-m-d H:i:s');
        $notification->created_by_id = '1';
        $notification->save(false);
        $model->delete();
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
