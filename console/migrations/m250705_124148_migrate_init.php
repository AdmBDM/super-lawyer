<?php

use yii\db\Migration;

class m250705_124148_migrate_init extends Migration
{
    /**
     * @return void
     */
    public function safeUp(): void
    {
        // 1. Функция обновления updated_at
        $this->execute("
            CREATE OR REPLACE FUNCTION set_updated_at()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.updated_at = NOW();
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");
    }

    /**
     * @return false
     */
    public function safeDown()
    {
        echo "m250705_124148_migrate_init cannot be reverted.\n";

        return false;
    }
}
