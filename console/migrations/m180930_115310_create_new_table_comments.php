<?php

use yii\db\Migration;

/**
 * Class m180930_115310_create_new_table_comments
 */
class m180930_115310_create_new_table_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'content' => $this->text(),
            'creation_time' => $this->dateTime(),
            'update_time' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('comments');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180930_115310_create_new_table_comments cannot be reverted.\n";

        return false;
    }
    */
}
