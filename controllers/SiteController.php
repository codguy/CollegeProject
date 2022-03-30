<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\search\TblUser;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup'],
                'rules' => [
                    [
                        'actions' => ['logout','signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'blank';
//         if (!Yii::$app->user->isGuest) {
//             return $this->goHome();
//         }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            var_dump($model);die;
            return $this->goBack();
        }

//         $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionSignup()
    {
        $model = new TblUser();
        $obj = rand(100,999);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->roll_id = \app\models\TblUser::IS_USER;
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by_id = '1';
                $model->state_id = '1';
                $model->authKey = 'test'.$obj.'.key';
                $model->accessToken = $obj.'-token';
                if ($model->save(false)) {
                    $this->redirect([
                        'index'
                    ]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        
        return $this->render('signup', [
            'model' => $model
        ]);
    }
}
