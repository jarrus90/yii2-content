<?php

namespace jarrus90\Content\Widgets;

use yii\base\InvalidConfigException;
use Yii;

/**
 * @package jarrus90\Content\Widgets
 */

class Redactor extends \yii\redactor\widgets\Redactor {

    /**
     * @return RedactorModule
     * @throws InvalidConfigException
     */
    public function getModule() {
        if (($baseModule = Yii::$app->getModule('content'))) {
            if (($module = $baseModule->getModule('redactor'))) {
                return $module;
            }
        }
        throw new InvalidConfigException('Invalid config Redactor module with "$moduleId"');
    }

}
