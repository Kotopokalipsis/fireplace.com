<?php

use yii\db\Migration;

/**
 * Class m180810_151428_add_new_table_post
 */
class m180810_151428_add_new_table_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'date' => $this->date(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180810_151428_add_new_table_post cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180810_151428_add_new_table_post cannot be reverted.\n";

        return false;
    }
    */
}
