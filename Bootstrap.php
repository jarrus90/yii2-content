<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jarrus90\Content;

use Yii;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

/**
 * Bootstrap class registers module and user application component. It also creates some url rules which will be applied
 * when UrlManager.enablePrettyUrl is enabled.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Bootstrap implements BootstrapInterface {

    /** @var array Model's map */
    private $_modelMap = [
        'Category' => 'jarrus90\Content\Models\Category',
        'Page' => 'jarrus90\Content\Models\Page',
        'Block' => 'jarrus90\Content\Models\Block',
    ];

    /** @inheritdoc */
    public function bootstrap($app) {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('content') && ($module = $app->getModule('content')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                $class = "jarrus90\\Content\\Models\\" . $name;
                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
                if (in_array($name, ['Category', 'Page', 'Block'])) {
                    Yii::$container->set("Content{$name}Query", function () use ($modelName) {
                        return $modelName::find();
                    });
                }
            }
            Yii::$container->setSingleton(ContentFinder::className(), [
                'categoryQuery' => Yii::$container->get('ContentCategoryQuery'),
                'pageQuery' => Yii::$container->get('ContentPageQuery'),
                'blockQuery' => Yii::$container->get('ContentBlockQuery'),
            ]);

            if (!$app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'jarrus90\Content\Controllers';
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
            }
            if (!isset($app->get('i18n')->translations['content*'])) {
                $app->get('i18n')->translations['content*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
            
            $app->params['yii.migrations'][] = '@jarrus90/Content/migrations/';
        }
    }

}
