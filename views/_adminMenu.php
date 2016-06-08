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
        ],
        [
            'label' => Yii::t('content', 'Categories'),
            'url' => ['/content/category/index'],
        ],
        [
            'label' => Yii::t('content', 'Blocks'),
            'url' => ['/content/block/index'],
        ],
        [
            'label' => Yii::t('content', 'Create'),
            'options' => [
                'class' => 'pull-right',
            ],
            'items' => [
                [
                    'label' => Yii::t('content', 'Page'),
                    'url' => ['/content/page/create'],
                ],
                [
                    'label' => Yii::t('content', 'Category'),
                    'url' => ['/content/category/create'],
                ],
                [
                    'label' => Yii::t('content', 'Block'),
                    'url' => ['/content/block/create'],
                ],
            ]
        ]
    ],
]);
?>