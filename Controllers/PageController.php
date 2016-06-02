<?php

namespace jarrus90\Content\Controllers;

use Yii;
use yii\base\Model;
use yii\base\Module as BaseModule;
use jarrus90\Content\ContentFinder;


class PageController extends ItemControllerAbstract {
    
    /**
     *
     * @var ContentFinder 
     */
    protected $finder;
    
    protected $modelClass = 'jarrus90\Content\Models\Page';
    
    protected $searchClass = 'jarrus90\Content\Models\PageSearch';
    
    /**
     * @param string  $id
     * @param BaseModule $module
     * @param ContentFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, ContentFinder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    protected function getItem($id) {
        return $this->finder->findBlock(['id' => $id]);
    }

}