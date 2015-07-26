<?php

use yii\db\Migration;
use yii\db\Schema;

class m141206_215634_create_user_table extends Migration
{

    public $userTable = '{{%user}}';
    public $userEmailTable = '{{%user_email}}';
    public $userProfileTable = '{{%user_profile}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            $this->userTable,
            [
                'id' => Schema::TYPE_PK,
                'username' => Schema::TYPE_STRING . '(30) NOT NULL',
                'email' => Schema::TYPE_STRING . '(100) NOT NULL',
                'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
                'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
                'secure_key' => Schema::TYPE_STRING . '(53) NOT NULL',
                'status_id' => 'tinyint(4) NOT NULL DEFAULT 0',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
            ],
            $tableOptions
        );
        // Indexes
        $this->createIndex('username', $this->userTable, 'username', true);
        $this->createIndex('email', $this->userTable, 'email', true);
        $this->createIndex('status_id', $this->userTable, 'status_id');
        $this->createIndex('created_at', $this->userTable, 'created_at');

        $this->createTable(
            $this->userProfileTable,
            [
                'user_id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . '(50) NOT NULL',
                'surname' => Schema::TYPE_STRING . '(50) NOT NULL',
                'avatar_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'sex' => Schema::TYPE_INTEGER . '(1) NOT NULL',
            ],
            $tableOptions
        );
        // Foreign Keys
        $this->addForeignKey('FK_profile_user', $this->userProfileTable, 'user_id', $this->userTable, 'id', 'CASCADE', 'CASCADE');

        $this->createTable(
            $this->userEmailTable,
            [
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'email' => Schema::TYPE_STRING . '(100) NOT NULL',
                'token' => Schema::TYPE_STRING . '(53) NOT NULL',
                'PRIMARY KEY (`user_id`, `token`)'
            ],
            $tableOptions
        );
        // Foreign Keys
        $this->addForeignKey(
            'FK_user_email_user',
            $this->userEmailTable,
            'user_id',
            $this->userTable,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->userProfileTable);
        $this->dropTable($this->userEmailTable);
        $this->dropTable($this->userTable);
    }
}