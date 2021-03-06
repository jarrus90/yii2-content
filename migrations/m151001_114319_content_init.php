<?php

namespace jarrus90\Content\migrations;

use Yii;

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
        $this->createIndex('content_page_unique', '{{%content_page}}', ['key', 'lang_code'], true);
        $this->addForeignKey('fk-content_page_lang', '{{%content_page}}', 'lang_code', '{{%languages}}', 'code', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%content_category}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
                ], $tableOptions);
        $this->createIndex('content_category_unique', '{{%content_category}}', ['key', 'lang_code'], true);
        $this->addForeignKey('fk-content_category_lang', '{{%content_category}}', 'lang_code', '{{%languages}}', 'code', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%content_category_page}}', [
            'page_key' => $this->string(255)->notNull(),
            'category_key' => $this->string(255)->notNull(),
                ], $tableOptions);
        $this->addPrimaryKey('pk-content_category_page', '{{%content_category_page}}', ['page_key', 'category_key']);
        
        $this->createTable('{{%content_block}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255)->notNull(),
            'lang_code' => $this->string(10)->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
                ], $tableOptions);
        $this->createIndex('content_block_unique', '{{%content_block}}', ['key', 'lang_code'], true);
        $this->addForeignKey('fk-content_block_lang', '{{%content_block}}', 'lang_code', '{{%languages}}', 'code', 'CASCADE', 'RESTRICT');
    }

    /**
     * Drop tables.
     */
    public function down() {
        $this->dropForeignKey('fk-content_block_lang', '{{%content_block}}');
        $this->dropForeignKey('fk-content_category_lang', '{{%content_category}}');
        $this->dropForeignKey('fk-content_page_lang', '{{%content_page}}');
        $this->dropTable('{{%content_category_page}}');
        $this->dropTable('{{%content_block}}');
        $this->dropTable('{{%content_category}}');
        $this->dropTable('{{%content_page}}');
    }

}
