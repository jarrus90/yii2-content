<?php

namespace jarrus90\Content;

use Yii;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

/**
 * Bootstrap class registers module and user application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 */
class Bootstrap implements BootstrapInterface {


    /** @inheritdoc */
    public function bootstrap($app) {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('content') && ($module = $app->getModule('content')) instanceof Module) {
            Yii::$container->setSingleton(ContentFinder::className(), [
                'categoryQuery' => \jarrus90\Content\Models\Category::find(),
                'pageQuery' => \jarrus90\Content\Models\Page::find(),
                'blockQuery' => \jarrus90\Content\Models\Block::find(),
            ]);

            if (!isset($app->get('i18n')->translations['content*'])) {
                $app->get('i18n')->translations['content*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
            
            if (!$app instanceof ConsoleApplication) {
                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules' => $module->urlRules,
                ];
                if ($module->urlPrefix != 'content') {
                    $configUrlRule['routePrefix'] = 'content';
                }
                $configUrlRule['class'] = 'yii\web\GroupUrlRule';
                $rule = Yii::createObject($configUrlRule);
                $app->urlManager->addRules([$rule], false);
                
                $app->params['admin']['menu']['content'] = function() use($module) {
                    return $module->getAdminMenu();
                };
            } else {
                if(empty($app->controllerMap['migrate'])) {
                    $app->controllerMap['migrate']['class'] = 'yii\console\controllers\MigrateController';
                }
                $app->controllerMap['migrate']['migrationNamespaces'][] = 'jarrus90\Content\migrations';
            }
        }
    }

}
