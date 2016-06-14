<?php

namespace jarrus90\Content\Models;

use Yii;

class CategoryForm extends \jarrus90\Core\Models\Model {

    public $key;
    public $title;
    public $description;
    public $lang_code;

    /**
     * Create form object
     * @param \app\modules\Blog\Models\BlogPost $post Post item
     */
    public function scenarios() {
        return [
            'create' => ['key', 'title', 'description', 'lang_code'],
            'update' => ['key', 'title', 'description', 'lang_code'],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if (!empty($this->item)) {
            $this->key = $this->_model->key;
            $this->title = $this->_model->title;
            $this->description = $this->_model->description;
            $this->lang_code = $this->_model->lang_code;
        }
    }

    public function __construct($config = []) {
        parent::__construct($config);
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['key', 'title', 'description', 'lang_code'], 'required'],
            'codeUnique' => ['key', 'unique', 'targetClass' => \jarrus90\Content\Models\Category::className(), 'message' => Yii::t('content', 'Key must be unique'), 'when' => function($model) {
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
            $this->_model->description = $this->cleanTextarea($this->description);
            $this->_model->lang_code = $this->lang_code;
            if ($this->_model->save()) {
                return $this->_model;
            }
        }
        return false;
    }

}
