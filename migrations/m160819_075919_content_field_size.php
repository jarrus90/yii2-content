<?php

namespace jarrus90\Content\migrations;

class m160819_075919_content_field_size extends \yii\db\Migration {

    public function up() {
        $this->alterColumn('{{%content_page}}', 'content', 'longtext');
    }

    public function down() {
        $this->alterColumn('{{%content_page}}', 'content', $this->text());
    }

}
