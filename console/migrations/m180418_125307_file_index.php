<?php

use yii\db\Migration;

/**
 * Class m180418_125307_file_index
 */
class m180418_125307_file_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('call', 'file_id', $this->integer());

        $this->createIndex('FK_CALL_FILE', 'call', 'file_id');
        $this->addForeignKey('FK_CALL_FILE', 'call', 'file_id', 'file', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180418_125307_file_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180418_125307_file_index cannot be reverted.\n";

        return false;
    }
    */
}
