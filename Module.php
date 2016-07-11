<?php

namespace jarrus90\Content;

use Yii;
use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

class Module extends BaseModule {

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'content';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<key:[A-Za-z0-9_-]+>' => 'front/page'
    ];
    public $filesUploadUrl = '@web/uploads/content';
    public $filesUploadDir = '@webroot/uploads/content';
    public $redactorConfig = [];
    public $useCommonStorage = true;

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

    public function getAdminMenu() {
        return [
            'label' => Yii::t('content', 'Content'),
            'position' => 30,
            'icon' => '<i class="fa fa-fw fa-newspaper-o"></i>',
            'items' => [
                [
                    'label' => Yii::t('content', 'Pages'),
                    'url' => '/content/page/index'
                ],
                [
                    'label' => Yii::t('content', 'Categories'),
                    'url' => '/content/category/index'
                ],
                [
                    'label' => Yii::t('content', 'Blocks'),
                    'url' => '/content/block/index'
                ],
            ]
        ];
    }

}
