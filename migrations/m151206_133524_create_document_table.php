<?php

use yii\db\Schema;
use yii\db\Migration;

class m151206_133524_create_document_table extends Migration
{
    private $tableName = '{{%document}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
