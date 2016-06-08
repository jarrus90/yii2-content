<?php

namespace jarrus90\Content\Widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;
use jarrus90\Content\Models\Block;

class BlockWidget extends Widget {

    /**
     * Block key
     * @var string
     */
    public $key;

    /**
     * Block render options
     * @var array
     */
    public $options = [];

    /**
     * Block render default options
     * @var array
     */
    protected $_defaultOptions = [
        'blockClass' => '',
        'titleClass' => '',
        'contentClass' => '',
    ];

    /**
     * Block render internal options
     * @var array
     */
    protected $_options;

    /**
     * Render block content
     * @return string
     */
    public function run() {
        if ($this->key == NULL) {
            return false;
        }
        $key = $this->key;
        $lang = Yii::$app->language;
        $dependency = new TagDependency(['tags' => ["content_block_key_{$key}_{$lang}"]]);
        $block = Block::getDb()->cache(function($db) use ($key, $lang) {
            return Block::findOne([
                        'key' => $key,
                        'lang_code' => $lang
            ]);
        }, 3600, $dependency);
        if (!$block) {
            \Yii::error("Block '{$key}' not found", 'CMS/BlockWidget');
            return false;
        }
        $this->_options = ArrayHelper::merge($this->_defaultOptions, $this->options);
        if ($block->content) {
            return $this->render('@jarrus90/Content/views/widgets/block', ['block' => $block, 'config' => $this->_options]);
        } else {
            return false;
        }
    }

}
