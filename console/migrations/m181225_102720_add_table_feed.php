<?php

use yii\db\Migration;

/**
 * Class m181225_102720_add_table_feed
 */
class m181225_102720_add_table_feed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('feed',[
           'id' => $this->primaryKey(),
           'user_id' => $this->integer(),
           'author_id' => $this->integer(),
           'author_nickname' => $this->string(),
           'author_photo' => $this->string(),
           'post_id' => $this->integer(),
           'post_content' => $this->text(),
           'post_uploads' => $this->string(),
           'post_created_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m181225_102720_add_table_feed cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181225_102720_add_table_feed cannot be reverted.\n";

        return false;
    }
    */
}
