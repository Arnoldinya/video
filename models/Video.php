<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $is_public
 *
 * @property FavVideo[] $favVideos
 * @property User[] $users
 * @property User $user
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'description', 'file_name'], 'required'],
            [['user_id', 'is_public'], 'integer'],
            [['description'], 'string'],
            [['file_name'], 'file', 'extensions' => ['mp4']],
            [['title'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Автор',
            'title' => 'Название',
            'description' => 'Описание',
            'is_public' => 'Публичное видео',
            'file_name' => 'Видео',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavVideos()
    {
        return $this->hasMany(FavVideo::className(), ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('fav_video', ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
    * Проверка, есть ли видео в избранном
    */
    public function isFav()
    {
        $oFavVideo = FavVideo::find()->where([
            'user_id' => Yii::$app->user->id,
            'video_id' => $this->id,
        ])->one();

        if($oFavVideo)
            return true;

        return false;
    }
}
