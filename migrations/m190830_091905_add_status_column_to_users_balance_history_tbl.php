<?php

use yii\db\Migration;

/**
 * Class m190830_091905_add_status_column_to_users_balance_history_tbl
 */
class m190830_091905_add_status_column_to_users_balance_history_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users_balance_history}}', 'status', $this->integer(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return $this->dropColumn('{{%users_balance_history}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190830_091905_add_status_column_to_users_balance_history_tbl cannot be reverted.\n";

        return false;
    }
    */
}
