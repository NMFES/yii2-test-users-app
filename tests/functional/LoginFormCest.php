<?php

class LoginFormCest
{

    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('users/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\Users::findByUsername('admin'));
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'demo=demo'
        ]);
        $I->expectTo('see validations errors');
        $I->see('Username is invalid');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin'
        ]);
        $I->see('Logout (admin)');
        $I->dontSeeElement('form#login-form');
    }

    public function logoutSuccessfully(\FunctionalTester $I)
    {
        $this->loginSuccessfully($I);

        $I->submitForm('#logout-form', []);
        $I->see('Login');
    }

}
