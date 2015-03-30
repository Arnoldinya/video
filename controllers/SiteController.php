<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Video;
use app\models\User;
use app\models\FavVideo;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    public function actionIndex()
    {
        $aVideo = Video::find()
        ->limit(10)
        ->orderBy('id desc')
        ->all();

        if(isset($_GET['fav']) && Yii::$app->user)
        {
            $aFavVideo = FavVideo::find()
            ->where([
                'user_id' => Yii::$app->user->id,
            ])
            ->limit(10)
            ->all();

            $aVideo = array();
            foreach ($aFavVideo as $oFavVideo) {
                $aVideo[] = $oFavVideo->video;
            }
        }
        if(isset($_GET['my']) && Yii::$app->user)
        {
            $aVideo = Video::find()
            ->where([
                'user_id' => Yii::$app->user->id
            ])
            ->limit(10)
            ->orderBy('id desc')
            ->all();
        }

        return $this->render('index', [
            'aVideo' => $aVideo,
        ]);
    }

    /**
    * Добавление в фав
    */
    public function actionAjaxaddtofav()
    {
        if(Yii::$app->user)
        {
            $iId = (int) $_POST['id'];
            $oFavVideo = new FavVideo();
            $oFavVideo->user_id = Yii::$app->user->id;
            $oFavVideo->video_id = $iId;

            if($oFavVideo->save())
                echo 'Добавлено!';
        }
    }

    /**
    * Регистрация
    */
    public function actionRegistration()
    {
        $oUser = new User();

        if ($oUser->load(Yii::$app->request->post()) && $oUser->save()) {
            if(Yii::$app->user)
                Yii::$app->user->logout();
            $oLoginForm = new LoginForm();
            $oLoginForm->username = $oUser->email;
            $oLoginForm->password = $oUser->pass;
            $oLoginForm->rememberMe = true;

            $oLoginForm->login();
            return $this->redirect(['/personal']);
        } else {
            return $this->render('register', [
                'oUser' => $oUser,
            ]);
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
