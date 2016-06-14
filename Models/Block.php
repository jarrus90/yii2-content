<?php

namespace jarrus90\Content\Models;

use yii\db\ActiveRecord;

class Block extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_block}}';
    }

}
