<?php


namespace jarrus90\Content\Controllers;

use Yii;
use yii\web\Response;
use jarrus90\Content\traits\ModuleTrait;

class UploadController extends \yii\web\Controller {

    use ModuleTrait;
    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    
    /**
     * List of available upload actions
     * 
     * @return array
     */
    public function actions() {
        return [
            'file' => [
                'class' => '\jarrus90\Redactor\Actions\FileUploadAction',
                'module' => $this->module->getModule('redactor'),
                'storage' => $this->module->storage
            ],
            'image' => [
                'class' => '\jarrus90\Redactor\Actions\ImageUploadAction',
                'module' => $this->module->getModule('redactor'),
                'storage' => $this->module->storage
            ],
            'file-json' => [
                'class' => '\jarrus90\Redactor\Actions\FileManagerJsonAction',
                'module' => $this->module->getModule('redactor'),
                'storage' => $this->module->storage
            ],
            'image-json' => [
                'class' => '\jarrus90\Redactor\Actions\ImageManagerJsonAction',
                'module' => $this->module->getModule('redactor'),
                'storage' => $this->module->storage
            ],
        ];
    }
}
