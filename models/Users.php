<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property integer $balance
 * @property string $auth_key
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const MAX_BALANCE = 9999999999.99;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return static::commonRules();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'balance' => 'Balance',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // sets zero balance and generates auth key
            if ($this->isNewRecord) {
                $this->balance = 0;
                $this->auth_key = Yii::$app->security->generateRandomString();
            }

            return true;
        }

        return false;
    }

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
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // we don't use access by accessToken
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => mb_strtolower($username, Yii::$app->charset)]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function commonRules()
    {
        return [
            ['username', 'required'],
            ['username', 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['username', 'match', 'pattern' => '/^[a-zа-яё0-9\-_]{3,30}$/iu'],
        ];
    }

    /**
     * Creates new user
     * @param string $username
     * @return Users
     */
    public static function createNewUser($username)
    {
        $user = new static();
        $user->username = $username;

        $user->save(false);

        return $user;
    }

}
