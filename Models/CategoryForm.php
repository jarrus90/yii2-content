<?php

/**
 * Class PostForm
 * 
 * @package app\modules\Blog\Forms
 */

namespace jarrus90\Content\Models;

use Yii;
/**
 * Form for posts saving and updating
 *
 * @property \app\modules\Blog\Models\BlogPost $_model Post item
 */
class CategoryForm extends \jarrus90\Core\Models\Model {

    public $key;
    public $title;
    public $description;
        
    /**
     * Create form object
     * @param \app\modules\Blog\Models\BlogPost $post Post item
     */
        
    public function scenarios() {
        return [
            'create' => ['key', 'title', 'description'],
            'update' => ['key', 'title', 'description'],
        ];
    }
    /** @inheritdoc */
    public function init() {
        parent::init();
        if(!empty($this->item)) {
            $this->key = $this->_model->key;
            $this->title = $this->_model->title;
            $this->description = $this->_model->description;
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
            'required' => [['key', 'title', 'description'], 'required'],
            'codeUnique' => ['key', 'unique', 'targetClass' => Yii::$app->getModule('content')->modelMap['Category'], 'message' => Yii::t('content', 'Key must be unique'), 'when' => function($model) {
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
            if ($this->_model->save()) {
                return $this->_model;
            }
        }
        return false;
    }
}
