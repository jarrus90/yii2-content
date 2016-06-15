<?php

namespace jarrus90\Content\Models;

use Yii;
use jarrus90\Multilang\Models\Language;

class BlockForm extends \jarrus90\Core\Models\Model {

    use \jarrus90\Content\traits\KeyCodeValidateTrait;

    public $key;
    public $title;
    public $content;
    public $lang_code;

    /**
     * Allowed textarea tag attributes
     * @var array
     */
    protected $_safeAttributes = [
        'style',
        'src'
    ];

    public function scenarios() {
        return [
            'create' => ['key', 'title', 'content', 'lang_code'],
            'update' => ['key', 'title', 'content', 'lang_code'],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if (!empty($this->_model)) {
            $this->key = $this->_model->key;
            $this->title = $this->_model->title;
            $this->content = $this->_model->content;
            $this->lang_code = $this->_model->lang_code;
        } else {
            throw new \yii\base\InvalidConfigException('Variable "item" should be set');
        }
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['key', 'title', 'content', 'lang_code'], 'required'],
            'keyValid' => ['key', 'validateKeyCodePair'],
            'langExists' => ['lang_code', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'code'],
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
            $this->_model->content = $this->cleanTextarea($this->content, $this->_safeAttributes, '<a>');
            $this->_model->lang_code = $this->lang_code;
            if ($this->_model->save()) {
                return $this->_model;
            }
        }
        return false;
    }

}
