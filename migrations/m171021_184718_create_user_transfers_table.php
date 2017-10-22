<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_transfers`.
 */
class m171021_184718_create_user_transfers_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_transfers', [
            'id' => $this->primaryKey(),
            'from_user_id' => $this->integer()->unsigned(),
            'to_user_id' => $this->integer()->unsigned(),
            'amount' => $this->decimal(12, 2)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_transfers');
    }

}
