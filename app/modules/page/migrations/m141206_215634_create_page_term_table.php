<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m141206_215634_create_page_table
 */
class m141206_215634_create_page_term_table extends Migration
{
    public $postTermTable = '{{%page_term}}';

    public $postTable = '{{%page_post}}';
    public $taxonomyVocabTable = '{{%taxonomy_vocabulary}}';
    public $taxonomyTermTable = '{{%taxonomy_term}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(
            $this->postTermTable,
            [
                'id' => Schema::TYPE_PK,
                'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'vocab_id' => Schema::TYPE_STRING . '(100) NOT NULL',
                'term_id' => Schema::TYPE_STRING . '(100) NOT NULL',
            ],
            $tableOptions
        );

        $this->addForeignKey('FK_page_post_id', $this->postTermTable, 'post_id', $this->postTable, 'id', 'CASCADE', 'CASCADE');
        //@TODO post table created before taxonomy table
        //$this->addForeignKey('FK_page_vocab_id', $this->postTermTable, 'vocab_id', $this->taxonomyVocabTable, 'id', 'CASCADE', 'CASCADE');
        //$this->addForeignKey('FK_page_term_id', $this->postTermTable, 'term_id', $this->taxonomyTermTable, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->postTermTable);
    }
}
