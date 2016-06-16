<?php

namespace jarrus90\Content;

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
            
    public $storageConfig = [
        'path' => '@webroot/uploads/content'
    ];
    
    public $redactorConfig = [];
        
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
        $this->components = [
            'storage' => ArrayHelper::merge([
                'class' => 'creocoder\flysystem\LocalFilesystem'
            ], $this->storageConfig),
        ];
    }
}
