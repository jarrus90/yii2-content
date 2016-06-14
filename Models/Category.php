<?php

namespace jarrus90\Content\Models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_category}}';
    }

}
