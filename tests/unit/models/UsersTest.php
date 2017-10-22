<?php

namespace tests\models;

use app\models\Users;

class UsersTest extends \Codeception\Test\Unit
{

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

    public function testFindUserById()
    {
        expect_that($user = Users::findIdentity(1));
        expect($user->username)->equals('admin');

        expect_not(Users::findIdentity(999));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = Users::findByUsername('admin'));
        expect_not(Users::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = Users::findByUsername('admin');
        expect_that($user->validateAuthKey('testKey'));
        expect_not($user->validateAuthKey('wrongKey'));
    }

}
