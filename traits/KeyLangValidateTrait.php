<?php

namespace jarrus90\Content\traits;

/**
 * Trait KeyCodeValidateTrait
 * @package jarrus90\Content\traits
 */
trait KeyLangValidateTrait {

    public function validateKeyLangPair($attribute) {
        if (($testItem = $this->findOne([
                    'key' => $this->key,
                    'lang_code' => $this->lang_code,
                ])) && $testItem->id != $this->id) {
            $this->addError($attribute, \Yii::t('content', 'Key must be unique for selected language'));
        }
    }

}
