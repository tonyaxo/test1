<?php

use yii\db\Migration;

/**
 * Class m180124_213422_init_app
 */
class m180124_213422_init_app extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'last_name' => $this->string(),
            'birthday' => $this->dateTime(),
            'sex' => $this->boolean()->notNull()->defaultValue(1)->comment('1 - male, 0 - female'),
            'phone_number' => $this->string(17)->notNull()->comment('format: +7 (777) 777-7777'),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%address_book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'value' => $this->string()->notNull(),
        ], $tableOptions);


        $this->addForeignKey('fk_Address_Book_user_id__User_id', '{{%address_book}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_Address_Book_user_id__User_id', '{{%address_book}}');

        $this->dropTable('{{%user}}');
        $this->dropTable('{{%address_book}}');
    }
}
