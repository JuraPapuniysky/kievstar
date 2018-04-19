<?php

use yii\db\Migration;

/**
 * Class m180419_073228_update_call
 */
class m180419_073228_update_call extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('call', 'duration', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180419_073228_update_call cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180419_073228_update_call cannot be reverted.\n";

        return false;
    }
    */
}
