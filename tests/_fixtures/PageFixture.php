<?php

namespace tests\unit\fixtures\Cms;

use yii\test\ActiveFixture;


class BlockContentFixture extends ActiveFixture {

    public $modelClass = 'jarrus90\Content\Models\Block';
    public $depends = [
        'jarrus90\Multilang\Models\BlockFixture'
    ];

    public function init() {
        parent::init();
        $this->dataFile = __DIR__ . '/BlockContentFixtureData.php';
    }

}