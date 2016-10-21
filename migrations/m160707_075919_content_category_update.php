<?php

namespace jarrus90\Content\migrations;

use Yii;

class m160707_075919_content_category_update extends \yii\db\Migration {

    public function up() {
        $this->dropTable('{{%content_category_page}}');
        $this->addColumn('{{%content_page}}', 'category_key', $this->string(255));
    }

    public function down() {
        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%content_category_page}}', [
            'page_key' => $this->string(255)->notNull(),
            'category_key' => $this->string(255)->notNull(),
                ], $tableOptions);
        $this->addPrimaryKey('pk-content_category_page', '{{%content_category_page}}', ['page_key', 'category_key']);
    }

}
