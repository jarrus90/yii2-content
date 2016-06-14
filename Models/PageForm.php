<?php

namespace jarrus90\Content\Models;

use Yii;

class PageForm extends \jarrus90\Core\Models\Model {

    public $key;
    public $title;
    public $content;
    public $lang_code;

    public function scenarios() {
        return [
            'create' => ['key', 'title', 'content', 'lang_code'],
            'update' => ['key', 'title', 'content', 'lang_code'],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if (!empty($this->item)) {
            $this->key = $this->_model->key;
            $this->title = $this->_model->title;
            $this->content = $this->_model->content;
            $this->lang_code = $this->_model->lang_code;
        }
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['key', 'title', 'content', 'lang_code'], 'required'],
            'codeUnique' => ['key', 'unique', 'targetClass' => \jarrus90\Content\Models\Page::className(), 'message' => Yii::t('content', 'Key must be unique'), 'when' => function($model) {
                    return $model->key != $model->_model->key;
                }],
        ];
    }

    /**
     * Attribute labels
     * @return array
     */
    public function attributeLabels() {
        return [
        ];
    }

    /**
     * Form save Post
     * @return |null
     */
    public function save() {
        if ($this->validate()) {
            $this->_model->key = $this->cleanTextinput($this->key);
            $this->_model->title = $this->cleanTextinput($this->title);
            $this->_model->content = $this->cleanTextarea($this->content);
            $this->_model->lang_code = $this->lang_code;
            if ($this->_model->save()) {
                return $this->_model;
            }
        }
        return false;
    }

}
