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

use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;
/**
 * This is the main module class for the Yii2-user.
 *
 * @property array $modelMap
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Module extends BaseModule {

    /** @var array Model map */
    public $modelMap = [];

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'content';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<name:[A-Za-z0-9_-]+>' => 'front/page'
    ];
    
    public $redactor = [];
    
    public function init() {
        parent::init();
        $this->modules = [
            'redactor' => ArrayHelper::merge([
                'class' => 'yii\redactor\RedactorModule',
                'imageUploadRoute' => '/content/upload/image',
                'fileUploadRoute' => '/content/upload/file',
                'imageManagerJsonRoute' => '/content/upload/image-json',
                'fileManagerJsonRoute' => '/content/upload/file-json'
            ], $this->redactor),
        ];
    }

}
