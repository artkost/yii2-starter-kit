<?php

use app\modules\page\models\PageModel;
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141206_215634_create_page_table
 */
class m141206_215634_create_page_post_table extends Migration
{
    public $postTable = '{{%page_post}}';
    public $postModelTable = '{{%page_model}}';
    public $userTable = '{{%user}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Post table
        $this->createTable($this->postTable, [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'model_class' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'title' => Schema::TYPE_STRING . '(100) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(100) NOT NULL',
            'snippet' => Schema::TYPE_TEXT . ' NOT NULL',
            'content' => 'longtext NOT NULL',
            'views' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'status_id' => 'tinyint(4) NOT NULL DEFAULT 0',
            'data' => 'longblob NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        // Indexes
        $this->createIndex('status_id', $this->postTable, 'status_id');
        $this->createIndex('views', $this->postTable, 'views');
        $this->createIndex('created_at', $this->postTable, 'created_at');
        $this->createIndex('updated_at', $this->postTable, 'updated_at');

        // Comment models table
        $this->createTable($this->postModelTable, [
            'id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL PRIMARY KEY',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'status_id' => 'tinyint(1) NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        $this->createIndex('name', $this->postModelTable, 'name');
        $this->createIndex('status_id', $this->postModelTable, 'status_id');
        $this->createIndex('created_at', $this->postModelTable, 'created_at');
        $this->createIndex('updated_at', $this->postModelTable, 'updated_at');

        // Foreign Keys
        $this->addForeignKey('FK_post_parent', $this->postTable, 'parent_id', $this->postTable, 'id', 'CASCADE', 'CASCADE');
        //@TODO fix priority of migrations execute, user table created after post table(!)
        //$this->addForeignKey('FK_post_author', $this->postTable, 'user_id', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_post_model_class', $this->postTable, 'model_class', $this->postModelTable, 'id', 'CASCADE', 'CASCADE');

        $this->addDefaultModels();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->postTable);
        $this->dropTable($this->postModelTable);
    }

    public function addDefaultModels()
    {
        $module = Yii::$app->getModule('page');

        foreach ($module->defaultModels as $modelClass) {
            if (class_exists($modelClass)) {
                $model = new PageModel([
                    'scenario' => 'admin-create',
                    'name' => $modelClass,
                    'status_id' => PageModel::STATUS_ENABLED
                ]);

                if ($model->save()) {
                    echo 'Page model class ' . $modelClass . ' added' . PHP_EOL;
                }
            }
        }
    }
}
