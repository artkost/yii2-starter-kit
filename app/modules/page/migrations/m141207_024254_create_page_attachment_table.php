<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141207_024254_create_page_table
 */
class m141207_024254_create_page_attachment_table extends Migration
{
    public $postFileTable = '{{%page_attachment}}';
    public $postTable = '{{%page_post}}';
    public $attachmentTable = '{{%attachment_file}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Post attachment
        $this->createTable($this->postFileTable, [
            'id' => Schema::TYPE_PK,
            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'attachment_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status_id' => 'tinyint(4) NOT NULL DEFAULT 0'
        ], $tableOptions);

        // Indexes
        $this->createIndex('status_id', $this->postFileTable, 'status_id');
        $this->createIndex('post_id', $this->postFileTable, 'post_id');
        $this->createIndex('attachment_id', $this->postFileTable, 'attachment_id');

        $this->addForeignKey('FK_page_post', $this->postFileTable, 'post_id', $this->postTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_attachment_file', $this->postFileTable, 'attachment_id', $this->attachmentTable, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->postFileTable);
    }
}
