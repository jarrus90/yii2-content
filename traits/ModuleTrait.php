<?php

namespace jarrus90\Content\traits;

use jarrus90\Content\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Content\traits
 */
trait ModuleTrait {

    /**
     * @return Module
     */
    public function getModule() {
        return \Yii::$app->getModule('content');
    }

}
