<?php

namespace tests\models;

use app\models\UserTransfers;

class UserTransfersTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _before()
    {
        
    }

    protected function _after()
    {
        
    }

    public function _fixtures()
    {
        return ['Users' => \app\tests\unit\fixtures\UsersFixture::className()];
    }

    public function testFormWorksCorrect()
    {
        $this->model = new UserTransfers();
        $this->model->username = 'user';
        $this->model->amount = 100;

        expect_that($this->model->validate());
    }

    public function testIncorrectUser()
    {
        $this->model = new UserTransfers();
        $this->model->username = 'demo=demo';
        $this->model->amount = 100;

        expect_not($this->model->validate());
        expect($this->model->getErrors())->hasKey('username');
    }

    public function testIncorrectAmount()
    {
        $this->model = new UserTransfers();
        $this->model->username = 'user';
        $this->model->amount = -100;

        expect_not($this->model->validate());
        expect($this->model->getErrors())->hasKey('amount');
    }

    public function testEmptyField()
    {
        $this->model = new UserTransfers();
        $this->model->username = '';
        $this->model->amount = '';

        expect_not($this->model->validate());
        expect($this->model->getErrors())->hasKey('username');
        expect($this->model->getErrors())->hasKey('amount');
    }

}
