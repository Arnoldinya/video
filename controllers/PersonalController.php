<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;

use app\models\Video;
use app\models\User;

class PersonalController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'controllers' => ['personal'],
                    ],
                ],
            ],
        ];
    }

    /**
    * Главная страница лк
    */
    public function actionIndex()
    {
        $oUser = User::findOne(Yii::$app->user->id);

        return $this->render("index", [
            'oUser' => $oUser,
        ]);
    }

    /**
    * Редактирвоание данный профиля
    */
    public function actionUpdate()
    {
        $oUser = User::findOne(Yii::$app->user->id);

        if ($oUser->load(Yii::$app->request->post()) && $oUser->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'oUser' => $oUser,
            ]);
        }
    }

    /**
    * Добавление видео
    */
    public function actionVideo()
    {
        $oVideo = new Video();

        if ($oVideo->load(Yii::$app->request->post()))
        {
            $oVideo->user_id = Yii::$app->user->id;
            $oVideo->file_name = UploadedFile::getInstance($oVideo, 'file_name');

            //echo "<pre>"; print_r($oVideo->attributes); echo "</pre>";exit;
            if($oVideo->save())
            {
                $oVideo->file_name->saveAs('uploads/'.$oVideo->file_name->name);

                return $this->redirect(['index']);
            }
        }

        return $this->render('video', [
            'oVideo' => $oVideo,
        ]);

    }
}
