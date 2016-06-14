<?php

namespace jarrus90\Content\Models;

use yii\db\ActiveRecord;

class Page extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_page}}';
    }

}
