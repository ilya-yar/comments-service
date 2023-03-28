<?php

use yii\db\Migration;

/**
 * Class m230326_193259_create_table_comment
 */
class m230326_193259_create_table_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string()->notNull(),
            'subject_id' => $this->integer()->notNull(),
            'username' => $this->string(),
            'comment' => $this->text()->notNull(),
            'status' => $this->string()->notNull(),
            'useragent' => $this->string(),
            'ip' => $this->string(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
