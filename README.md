# Yii 2 Test Users App

## Installation

For installing you should run next commands:

* `git clone https://github.com/NMFES/yii2-test-users-app.git`
* `cd yii2-test-users-app`
* `composer install`
* `php yii migrate`
* `php yii fixture/load "*" (if needed)`
* Also you need to configure your DB connection in configs/db.php and configs/test_db.php (and create selected DB, ofc)
* For testing you can use next command:
* `vendor/bin/codecept run`

## What's included

* Login(registration if needed)/Logout
* List of all user's transfers
* Creating a new transfer to another user
* Index page with all users and their balance

<img src="https://raw.githubusercontent.com/NMFES/yii2-test-users-app/master/web/img/1.png" height="500">
<img src="https://raw.githubusercontent.com/NMFES/yii2-test-users-app/master/web/img/2.png" height="500">
<img src="https://raw.githubusercontent.com/NMFES/yii2-test-users-app/master/web/img/3.png" height="500">
<img src="https://raw.githubusercontent.com/NMFES/yii2-test-users-app/master/web/img/4.png" height="500">
