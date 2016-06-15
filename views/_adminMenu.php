<?php

/**
 * @var $this yii\web\View
 */
use yii\bootstrap\Nav;
?>
<?=
Nav::widget([
    'options' => [
        'class' => 'nav-tabs'
    ],
    'items' => [
        [
            'label' => Yii::t('content', 'Pages'),
            'url' => ['/content/page/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Content\Controllers\PageController)
        ],
        [
            'label' => Yii::t('content', 'Categories'),
            'url' => ['/content/category/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Content\Controllers\CategoryController)
        ],
        [
            'label' => Yii::t('content', 'Blocks'),
            'url' => ['/content/block/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Content\Controllers\BlockController)
        ]
    ],
]);
?>