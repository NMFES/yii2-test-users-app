<?php

namespace app\models;

use Yii;
use app\models\Users;

/**
 * This is the model class for table "user_transfers".
 *
 * @property integer $id
 * @property string $from_user_id
 * @property string $to_user_id
 * @property string $amount
 */
class UserTransfers extends \yii\db\ActiveRecord
{
    public $username;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_transfers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(Users::commonRules(), [
            ['username', 'anotherUser'],
            ['amount', 'required'],
            ['amount', 'number', 'min' => 0.01, 'max' => Users::MAX_BALANCE],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'username' => 'Username',
            'amount' => 'Amount',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'to_user_id']);
    }

    public function anotherUser($attribute, $params)
    {
        if (Yii::$app->user->identity->username == $this->$attribute) {
            $this->addError($attribute, 'You can\'t transfer money to yourself');
        }
    }

    /**
     * Transfers money from us to specified user
     * @return boolean
     */
    public function transfer()
    {
        $receiver = Users::findByUsername($this->username);

        // creates a new user if doesn't exist
        if (!is_object($receiver)) {
            $receiver = Users::createNewUser($this->username);
        }

        if (Yii::$app->user->identity->balance - $this->amount < -Users::MAX_BALANCE) {
            $this->addError('amount', 'Your balance after transfer cannot be less than -' . Users::MAX_BALANCE);
        }

        if ($receiver->balance + $this->amount > Users::MAX_BALANCE) {
            $this->addError('amount', 'Receiver\'s balance after transfer cannot be more than' . Users::MAX_BALANCE);
        }

        if (!$this->hasErrors()) {
            Yii::$app->db->transaction(function($db) use($receiver) {
                Yii::$app->user->identity->balance -= $this->amount;
                Yii::$app->user->identity->save(false);

                $receiver->balance += $this->amount;
                $receiver->save(false);

                $this->from_user_id = Yii::$app->user->id;
                $this->to_user_id = $receiver->id;
                $this->save(false);
            });

            return true;
        }

        return false;
    }

}
