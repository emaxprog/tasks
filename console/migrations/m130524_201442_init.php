<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique()->comment('E-mail'),
            'person_type' => $this->string(16)->notNull()->comment('Тип лица'),
            'name' => $this->string(32)->notNull()->comment('Имя'),
            'last_name' => $this->string(64)->notNull()->comment('Фамилия'),
            'middle_name' => $this->string(32)->notNull()->comment('Отчество'),
            'inn' => $this->string(12)->notNull()->comment('ИНН'),
            'organization_name' => $this->string()->comment('Название организации'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
