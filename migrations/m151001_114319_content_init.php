<?php

class m151001_114319_content_init extends \yii\db\Migration {

    /**
     * Create tables.
     */
    public function up() {

        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content_page}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
                ], $tableOptions);

        $this->createTable('{{%content_category}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
                ], $tableOptions);

        $this->createTable('{{%content_block}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
                ], $tableOptions);
    }

    /**
     * Drop tables.
     */
    public function down() {
        $this->dropTable('{{%content_block}}');
        $this->dropTable('{{%content_category}}');
        $this->dropTable('{{%content_page}}');
    }

}
