<?php

namespace app\models;

use Yii;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $pass
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    public $passRepeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name', 'surname', 'pass', 'passRepeat'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['passRepeat'], 'validateRepeat'],
            [['email', 'name', 'surname', 'pass'], 'string', 'max' => 250]
        ];
    }

    /**
     * Проверка повтора пароля
     */
    public function validateRepeat($attribute, $params)
    {
        if($this->pass!=$this->passRepeat)
            $this->addError($attribute, 'Пароли не совпадают.');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'pass' => 'Пароль',
            'passRepeat' => 'Повтор пароля',
        ];
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->pass === $password;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getFavVideos()
    {
        return $this->hasMany(FavVideo::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['user_id' => 'id']);
    }

    public function getFIO()
    {
        return $this->surname.' '.$this->name;
    }
}
