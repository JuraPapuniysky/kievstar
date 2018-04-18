<?php

use yii\db\Migration;

/**
 * Class m180418_072923_db
 */
class m180418_072923_db extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('call', [
            'id' => $this->primaryKey(),
            'date_time' => $this->dateTime(),
            'type' => $this->string(),
            'call_directions' => $this->string(),
            'phone' => $this->string(),
            'cost_balance' => $this->float(),
            'cost' => $this->float(),
            'catalog_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('FK_CALL_CATALOG', 'call', 'catalog_id');
        $this->addForeignKey('FK_CALL_CATALOG', 'call', 'catalog_id', 'catalog', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180418_072923_db cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180418_072923_db cannot be reverted.\n";

        return false;
    }
    */
}
