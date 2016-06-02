<?php

namespace jarrus90\Content\Models;

use yii\db\ActiveRecord;
use jarrus90\Content\ContentFinder;
use jarrus90\Content\traits\ModuleTrait;

class Category extends ActiveRecord {

    use ModuleTrait;

    /** @var UserFinder */
    protected static $finder;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_category}}';
    }

    /**
     * @return UserFinder
     */
    protected static function getCategoryFinder() {
        if (static::$finder === null) {
            static::$finder = \Yii::$container->get(ContentFinder::className());
        }

        return static::$finder;
    }
}
