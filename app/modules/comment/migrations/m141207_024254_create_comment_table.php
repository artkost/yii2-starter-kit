<?php

use app\modules\comment\models\CommentModel;
use yii\db\Migration;
use yii\db\Schema;

/**
 * CLass m140911_074715_create_module_tbl
 *
 * Create module tables.
 *
 * Will be created 1 table:
 * - `{{%comments}}` - Comments table.
 */
class m141207_024254_create_comment_table extends Migration
{
    public $commentTable = '{{%comment}}';
    public $commentModelTable = '{{%comment_model}}';
    public $userTable = '{{%user}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Comment models table
        $this->createTable($this->commentModelTable, [
            'id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL PRIMARY KEY',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'status_id' => 'tinyint(1) NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        $this->createIndex('name', $this->commentModelTable, 'name');
        $this->createIndex('status_id', $this->commentModelTable, 'status_id');
        $this->createIndex('created_at', $this->commentModelTable, 'created_at');
        $this->createIndex('updated_at', $this->commentModelTable, 'updated_at');

        // Comments table
        $this->createTable($this->commentTable, [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'model_class' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'status_id' => 'tinyint(2) NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        // Indexes
        $this->createIndex('status_id', $this->commentTable, 'status_id');
        $this->createIndex('created_at', $this->commentTable, 'created_at');
        $this->createIndex('updated_at', $this->commentTable, 'updated_at');

        // Foreign Keys
        $this->addForeignKey('FK_comment_parent', $this->commentTable, 'parent_id', $this->commentTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_author', $this->commentTable, 'author_id', $this->userTable, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_model_class', $this->commentTable, 'model_class', $this->commentModelTable, 'id', 'CASCADE', 'CASCADE');

        $this->addDefaultModels();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->commentTable);
        $this->dropTable($this->commentModelTable);
    }

    public function addDefaultModels()
    {
        $module = Yii::$app->getModule('comment');

        foreach ($module->defaultModels as $modelClass) {
            if (class_exists($modelClass)) {
                $model = new CommentModel([
                    'scenario' => 'admin-create',
                    'name' => $modelClass,
                    'status_id' => CommentModel::STATUS_ENABLED
                ]);

                if ($model->save()) {
                    echo 'Comment model class ' . $modelClass . ' added' . PHP_EOL;
                }
            }
        }
    }
}
