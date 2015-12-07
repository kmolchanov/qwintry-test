<?php

use yii\db\Schema;
use yii\db\Migration;

class m151207_074452_create_attachment_table extends Migration
{
    private $tableName = '{{%attachment}}';
    private $documentTableName = '{{%document}}';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'original_name' => $this->string()->notNull(),
            'size' => $this->integer()->notNull(),
            'document_id' => $this->integer(),
        ]);

        $this->addForeignKey('FK_document_id', $this->tableName, 'document_id', $this->documentTableName, 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('FK_document_id', $this->tableName);
        $this->dropTable($this->tableName);;
    }
}
