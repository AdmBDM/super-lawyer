<?php
use yii\db\Migration;

/**
 * Добавляет is_fiz / is_jur и переводит body → jsonb
 * в таблицах service и service_city.
 */
class m250705_190412_alter_service_tables extends Migration
{
    private const T_SERVICE      = '{{%service}}';
    private const T_SERVICECITY  = '{{%service_city}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        /* ---------- service ---------- */
        if (!$this->db->getTableSchema(self::T_SERVICE, true)->getColumn('is_fiz')) {
            $this->addColumn(self::T_SERVICE, 'is_fiz', $this->boolean()->defaultValue(true));
        }
        if (!$this->db->getTableSchema(self::T_SERVICE, true)->getColumn('is_jur')) {
            $this->addColumn(self::T_SERVICE, 'is_jur', $this->boolean()->defaultValue(true));
        }

        // body → jsonb
        $this->execute('ALTER TABLE {{%service}} ALTER COLUMN body DROP DEFAULT');

        $this->execute("
            ALTER TABLE ".self::T_SERVICE."
            ALTER COLUMN body TYPE jsonb
            USING CASE
                     WHEN body IS NULL OR body = '' THEN '{}'::jsonb
                     WHEN body ~ '^[\\s\\n]*\\{'              -- уже JSON
                          THEN body::jsonb
                     ELSE jsonb_build_object('text', body)::jsonb
                 END;
        ");

        $this->execute("ALTER TABLE {{%service}} ALTER COLUMN body SET DEFAULT '{}'::jsonb");

        /* ---------- service_city ---------- */
        if (!$this->db->getTableSchema(self::T_SERVICECITY, true)->getColumn('is_fiz')) {
            $this->addColumn(self::T_SERVICECITY, 'is_fiz', $this->boolean()->defaultValue(true));
        }
        if (!$this->db->getTableSchema(self::T_SERVICECITY, true)->getColumn('is_jur')) {
            $this->addColumn(self::T_SERVICECITY, 'is_jur', $this->boolean()->defaultValue(true));
        }

        // body → jsonb
        $this->execute('ALTER TABLE {{%service_city}} ALTER COLUMN body DROP DEFAULT');

        $this->execute("
            ALTER TABLE ".self::T_SERVICECITY."
            ALTER COLUMN body TYPE jsonb
            USING CASE
                     WHEN body IS NULL OR body = '' THEN '{}'::jsonb
                     WHEN body ~ '^[\\s\\n]*\\{' THEN body::jsonb
                     ELSE jsonb_build_object('text', body)::jsonb
                 END;
        ");

        $this->execute("ALTER TABLE {{%service_city}} ALTER COLUMN body SET DEFAULT '{}'::jsonb");
    }

    /**
     * @return false
     */
    public function safeDown(): false
    {
        echo "m250705_190412_alter_service_tables cannot be reverted.\n";
        return false;
    }
}
