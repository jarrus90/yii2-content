<?php

class m160718_075919_content_page_meta extends \yii\db\Migration {

    public function up() {
        $this->addColumn('{{%content_page}}', 'meta_keywords', $this->text());
        $this->addColumn('{{%content_page}}', 'meta_description', $this->text());
    }

    public function down() {
        $this->dropColumn('{{%content_page}}', 'meta_keywords');
        $this->dropColumn('{{%content_page}}', 'meta_description');
    }

}
