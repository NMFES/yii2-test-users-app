<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m171021_183527_create_users_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(30),
            'balance' => $this->decimal(12, 2),
            'auth_key' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }

}
