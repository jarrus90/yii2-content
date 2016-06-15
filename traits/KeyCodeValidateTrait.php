<?php

namespace jarrus90\Content\traits;

use yii\validators\ExistValidator;
use jarrus90\Content\Module;
use jarrus90\Multilang\Models\Language;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Content\traits
 */
trait KeyCodeValidateTrait {

    public function validateKeyCodePair($attribute) {
        $existValidator = \Yii::createObject([
            'class' => ExistValidator::className(),
            'targetClass' => Language::className(),
            'targetAttribute' => 'code'
        ]);

        $errorLangExists = null;
        $existValidator->validate($this->lang_code, $errorLangExists);
        if (!empty($errorLangExists)) {
            $this->addError('lang_code', $errorLangExists);
        } else {
            if ($this->_model->findOne([
                        'key' => $this->key,
                        'lang_code' => $this->lang_code,
                    ])) {
                $this->addError($attribute, \Yii::t('content', 'Key must be unique for selected language'));
            }
        }
    }

}
