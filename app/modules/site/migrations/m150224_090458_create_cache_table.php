<?php

use app\modules\comment\models\CommentModel;
use yii\db\Migration;
use yii\db\Schema;

/***
 * Create module tables.
 *
 * Will be created 1 table:
 * - `{{%cache}}` - default cache table.
 */
class m150224_090458_create_cache_table extends Migration
{
    public $cacheTable = '{{%cache}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Comment models table
        $this->createTable($this->cacheTable, [
            'id' => $this->primaryKey(),
            'expire' => $this->integer()->notNull(),
            'data' => $this->binary()
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->cacheTable);
    }
}
