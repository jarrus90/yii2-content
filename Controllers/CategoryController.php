<?php

namespace jarrus90\Content\Controllers;

use yii\base\Module as BaseModule;
use jarrus90\Content\ContentFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;

class CategoryController extends AdminCrudAbstract {
    
    /**
     *
     * @var ContentFinder 
     */
    protected $finder;
    
    protected $modelClass = 'jarrus90\Content\Models\Category';
    
    protected $formClass = 'jarrus90\Content\Models\CategoryForm';
    
    protected $searchClass = 'jarrus90\Content\Models\CategorySearch';
    
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
        return $this->finder->findCategory(['id' => $id])->one();
    }

}