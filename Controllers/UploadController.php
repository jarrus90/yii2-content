<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace jarrus90\Content\Controllers;

use Yii;
use yii\web\Response;
use jarrus90\Content\traits\ModuleTrait;
/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
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
                'module' => $this->module->getModule('redactor')
            ],
            'image' => [
                'class' => '\jarrus90\Redactor\Actions\ImageUploadAction',
                'module' => $this->module->getModule('redactor')
            ],
            'file-json' => [
                'class' => '\jarrus90\Redactor\Actions\FileManagerJsonAction',
                'module' => $this->module->getModule('redactor')
            ],
            'image-json' => [
                'class' => '\jarrus90\Redactor\Actions\ImageManagerJsonAction',
                'module' => $this->module->getModule('redactor')
            ],
        ];
    }
}
