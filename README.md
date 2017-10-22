# Yii 2 Test Users App

## Installation

For installing you should run next commands:

* `git clone https://github.com/NMFES/yii2-test-users-app.git`
* `cd yii2-test-users-app`
* `composer install`
* `php yii migrate`
* `php yii fixture/load "*"`
* Also you need to configure your DB connection in configs/db.php (and create selected DB, ofc)

## What's included

* Login(registration if needed)/Logout
* List of all user's transfers
* Creating a new transfer to another user
* Index page with all users and their balance
