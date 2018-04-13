<?php

use yii\db\Migration;

class m170614_052804_init_balance_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_balance',[
            'user_id' => $this->primaryKey(),
            'balance' => $this->decimal(10,2),
        ]);

        $this->createTable('users_balance_history',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'sum' => $this->decimal(10,2),
            'method' => $this->string(31),
            'comment'=> $this->text(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('users_balance');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170614_052804_init_balance_tables cannot be reverted.\n";

        return false;
    }
    */
}
