<?php

use yii\db\Migration;

/**
 * Таблица часто задаваемых вопросов (FAQ),
 * с привязкой к услуге (обязательно) и городу (опционально)
 */
class m250710_175133_create_faq_table extends Migration
{
    /**
     * @return void
     */
    public function safeUp(): void
    {
        if (!$this->db->getTableSchema('{{%faq}}', true)) {
            $this->createTable('{{%faq}}', [
                'id' => $this->primaryKey(),
                'service_id' => $this->integer()->notNull(),
                'city_id' => $this->integer()->null(),
                'question' => $this->text()->notNull(),
                'answer' => $this->text()->notNull(),
                'is_active' => $this->boolean()->defaultValue(true),
                'created_at' => $this->timestamp()->defaultExpression('NOW()'),
                'updated_at' => $this->timestamp()->defaultExpression('NOW()'),
            ]);

            $this->addForeignKey('fk_faq_service', '{{%faq}}', 'service_id', '{{%service}}', 'id', 'CASCADE');
            $this->addForeignKey('fk_faq_city', '{{%faq}}', 'city_id', '{{%city}}', 'id', 'SET NULL');

            // Триггер автообновления updated_at
            $this->execute(
                "
                CREATE TRIGGER trg_faq_updated
                BEFORE UPDATE ON {{%faq}}
                FOR EACH ROW
                EXECUTE PROCEDURE update_updated_at_column();
            ");
        }
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%faq}}');
    }
}

