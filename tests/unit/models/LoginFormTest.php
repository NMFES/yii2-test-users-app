<?php

namespace tests\models;

use app\models\LoginForm;
use Codeception\Specify;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function _fixtures()
    {
        return ['Users' => \app\tests\unit\fixtures\UsersFixture::className()];
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username'
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
    }

    public function testLoginIncorrect()
    {
        $this->model = new LoginForm([
            'username' => 'demo=demo'
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('username');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'demo'
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('username');
    }

}
