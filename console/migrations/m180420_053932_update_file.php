<?php

use yii\db\Migration;

/**
 * Class m180420_053932_update_file
 */
class m180420_053932_update_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('file', 'month', $this->char(2));
        $this->addColumn('file', 'year', $this->char(4));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180420_053932_update_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180420_053932_update_file cannot be reverted.\n";

        return false;
    }
    */
}
