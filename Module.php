<?php

namespace jarrus90\Content;

use Yii;
use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

/**
 * @package jarrus90\Content
 */
class Module extends BaseModule {

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[yii\web\GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'content';

    /**
     * @var array The rules to be used in URL management.
     */
    public $urlRules = [
        '<key:[A-Za-z0-9_-]+>' => 'front/page'
    ];

    /**
     * @var string Url for uploads.
     */
    public $filesUploadUrl = '@web/uploads/content';

    /**
     * @var string Path for uploads.
     */
    public $filesUploadDir = '@webroot/uploads/content';

    /**
     * @var array Configuration for redactor.
     */
    public $redactorConfig = [];

    /**
     * @var bool
     */
    public $useCommonStorage = false;

    /** @inheritdoc */
    public function init() {
        parent::init();
        $this->modules = [
            'redactor' => ArrayHelper::merge([
                'class' => 'jarrus90\Redactor\Module',
                'imageUploadRoute' => '/content/upload/image',
                'fileUploadRoute' => '/content/upload/file',
                'imageManagerJsonRoute' => '/content/upload/image-json',
                'fileManagerJsonRoute' => '/content/upload/file-json',
                'uploadUrl' => '@web/uploads/content'
                    ], $this->redactorConfig, [
                'uploadUrl' => $this->filesUploadUrl,
                'uploadDir' => $this->filesUploadDir,
            ]),
        ];
        if (!$this->get('storage', false)) {
            if ($this->useCommonStorage && ($storage = Yii::$app->get('storage', false))) {
                $this->set('storage', $storage);
            } else {
                $this->set('storage', [
                    'class' => 'creocoder\flysystem\LocalFilesystem',
                    'path' => $this->filesUploadDir
                ]);
            }
        }
    }

    /**
     * Get list of admin menu items
     * @return array List
     */
    public function getAdminMenu() {
        return [
            'content' => [
                'label' => Yii::t('content', 'Content'),
                'icon' => 'fa fa-fw fa-newspaper-o',
                'position' => 30,
                'visible' => Yii::$app->user->can('content_publisher'),
                'items' => [
                    [
                        'label' => Yii::t('content', 'Pages'),
                        'url' => ['/content/page/index'],
                        'visible' => Yii::$app->user->can('content_publisher')
                    ],
                    [
                        'label' => Yii::t('content', 'Categories'),
                        'url' => ['/content/category/index'],
                        'visible' => Yii::$app->user->can('content_publisher')
                    ],
                    [
                        'label' => Yii::t('content', 'Blocks'),
                        'url' => ['/content/block/index'],
                        'visible' => Yii::$app->user->can('content_publisher')
                    ],
                ]
            ]
        ];
    }

}
