<?php

namespace jarrus90\Content\controllers;

use yii\web\Response;
use jarrus90\Content\traits\ModuleTrait;

/**
 * @package jarrus90\Content\controllers
 */

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
                'module' => $this->getModule()->getModule('redactor'),
                'storage' => $this->getModule()->storage
            ],
            'image' => [
                'class' => '\jarrus90\Redactor\Actions\ImageUploadAction',
                'module' => $this->getModule()->getModule('redactor'),
                'storage' => $this->getModule()->storage
            ],
            'file-json' => [
                'class' => '\jarrus90\Redactor\Actions\FileManagerJsonAction',
                'module' => $this->getModule()->getModule('redactor'),
                'storage' => $this->getModule()->storage
            ],
            'image-json' => [
                'class' => '\jarrus90\Redactor\Actions\ImageManagerJsonAction',
                'module' => $this->getModule()->getModule('redactor'),
                'storage' => $this->getModule()->storage
            ],
        ];
    }
}
