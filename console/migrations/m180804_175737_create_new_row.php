<?php

use yii\db\Migration;

/**
 * Class m180804_175737_create_new_row
 */
class m180804_175737_create_new_row extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('user', 'profile_img', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('user', 'profile_img');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180804_175737_create_new_row cannot be reverted.\n";

        return false;
    }
    */
}
