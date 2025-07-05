<?php

use yii\db\Migration;

class m250705_124325_create_core_tables extends Migration
{
    /**
     * @return void
     */
    public function safeUp()
    {
        // Таблица: user
        if (!$this->db->getTableSchema('{{%user}}', true)) {
            $this->createTable('{{%user}}', [
                'id'                    => $this->primaryKey(),
                'username'              => $this->string()->notNull()->unique(),
                'auth_key'              => $this->string(32)->notNull(),
                'password_hash'         => $this->string()->notNull(),
                'password_reset_token'  => $this->string()->unique(),
                'email'                 => $this->string()->notNull()->unique(),
                'status'                => $this->smallInteger()->notNull()->defaultValue(10),
                'phone'                 => $this->string()->notNull()->unique(),
                'is_admin'              => $this->boolean()->notNull()->defaultValue(false),
                'verification_token'    => $this->string()->defaultValue(null),
                'created_at'            => 'TIMESTAMP DEFAULT NOW()',
                'updated_at'            => 'TIMESTAMP DEFAULT NOW()',
            ]);

            $this->execute("CREATE TRIGGER trg_user_updated BEFORE UPDATE ON {{%user}} FOR EACH ROW EXECUTE FUNCTION set_updated_at();");
        }

        // Таблица: city
        if (!$this->db->getTableSchema('{{%city}}', true)) {
            $this->createTable('{{%city}}', [
                'id'           => $this->primaryKey(),
                'slug'         => $this->string(32)->notNull()->unique(),
                'name'         => $this->string(64)->notNull(),
                'genitive'     => $this->string(64),
                'dative'       => $this->string(64),
                'phone'        => $this->string(32),
                'in_location'  => $this->boolean()->defaultValue(false),
                'is_active'    => $this->boolean()->defaultValue(true),
                'created_at'   => 'TIMESTAMP DEFAULT NOW()',
                'updated_at'   => 'TIMESTAMP DEFAULT NOW()',
            ]);

            $this->execute("CREATE TRIGGER trg_city_updated BEFORE UPDATE ON {{%city}} FOR EACH ROW EXECUTE FUNCTION set_updated_at();");
        }

        // Таблица: service
        if (!$this->db->getTableSchema('{{%service}}', true)) {
            $this->createTable('{{%service}}', [
                'id'            => $this->primaryKey(),
                'slug'          => $this->string(64)->notNull()->unique(),
                'title'         => $this->string(128)->notNull(),
                'icon'          => $this->string(64),
                'h1'            => $this->string(255),
                'lead'          => $this->text(),
                'body'          => $this->text(),
                'price_from'    => $this->decimal(10, 2),
                'meta_title'    => $this->string(255),
                'meta_desc'     => $this->text(),
                'meta_keywords' => $this->text(),
                'is_active'     => $this->boolean()->defaultValue(true),
                'created_at'    => 'TIMESTAMP DEFAULT NOW()',
                'updated_at'    => 'TIMESTAMP DEFAULT NOW()',
            ]);

            $this->execute("CREATE TRIGGER trg_service_updated BEFORE UPDATE ON {{%service}} FOR EACH ROW EXECUTE FUNCTION set_updated_at();");
        }

        // Таблица: service_city
        if (!$this->db->getTableSchema('{{%service_city}}', true)) {
            $this->createTable('{{%service_city}}', [
                'id'            => $this->primaryKey(),
                'city_id'       => $this->integer()->notNull(),
                'service_id'    => $this->integer()->notNull(),
                'h1'            => $this->string(255),
                'lead'          => $this->text(),
                'body'          => $this->text(),
                'price_from'    => $this->decimal(10,2),
                'meta_title'    => $this->string(255),
                'meta_desc'     => $this->text(),
                'meta_keywords' => $this->text(),
                'is_active'     => $this->boolean()->defaultValue(true),
                'created_at'    => 'TIMESTAMP DEFAULT NOW()',
                'updated_at'    => 'TIMESTAMP DEFAULT NOW()',
            ]);

            $this->addForeignKey('fk_service_city_city',    '{{%service_city}}', 'city_id',    '{{%city}}',    'id', 'CASCADE');
            $this->addForeignKey('fk_service_city_service', '{{%service_city}}', 'service_id', '{{%service}}', 'id', 'CASCADE');
            $this->createIndex('idx_service_city_unique', '{{%service_city}}', ['city_id', 'service_id'], true);
            $this->execute("CREATE TRIGGER trg_service_city_updated BEFORE UPDATE ON {{%service_city}} FOR EACH ROW EXECUTE FUNCTION set_updated_at();");
        }

        // Таблица: page_block
        if (!$this->db->getTableSchema('{{%page_block}}', true)) {
            $this->createTable('{{%page_block}}', [
                'id'               => $this->primaryKey(),
                'service_city_id'  => $this->integer()->notNull(),
                'type'             => $this->string(32)->notNull(),
                'title'            => $this->string(255),
                'content'          => $this->text(),
                'sort'             => $this->integer()->defaultValue(0),
                'is_active'        => $this->boolean()->defaultValue(true),
                'created_at'       => 'TIMESTAMP DEFAULT NOW()',
                'updated_at'       => 'TIMESTAMP DEFAULT NOW()',
            ]);

            $this->addForeignKey('fk_page_block_service_city', '{{%page_block}}', 'service_city_id', '{{%service_city}}', 'id', 'CASCADE');
            $this->execute("CREATE TRIGGER trg_page_block_updated BEFORE UPDATE ON {{%page_block}} FOR EACH ROW EXECUTE FUNCTION set_updated_at();");
        }

        // Таблица: seo_redirect
        if (!$this->db->getTableSchema('{{%seo_redirect}}', true)) {
            $this->createTable('{{%seo_redirect}}', [
                'id'         => $this->primaryKey(),
                'old_path'   => $this->string(255)->notNull()->unique(),
                'new_path'   => $this->string(255)->notNull(),
                'code'       => $this->smallInteger()->defaultValue(301),
                'comment'    => $this->string(255),
                'is_active'  => $this->boolean()->defaultValue(true),
                'created_at' => 'TIMESTAMP DEFAULT NOW()',
                'updated_at' => 'TIMESTAMP DEFAULT NOW()',
            ]);

            $this->execute("CREATE TRIGGER trg_seo_redirect_updated BEFORE UPDATE ON {{%seo_redirect}} FOR EACH ROW EXECUTE FUNCTION set_updated_at();");
        }
    }


    /**
     * @return false
     */
    public function safeDown()
    {
        echo "m250705_124325_create_core_tables cannot be reverted.\n";

        return false;
    }
}
