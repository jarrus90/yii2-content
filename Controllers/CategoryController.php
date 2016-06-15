<?php

namespace jarrus90\Content\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Content\ContentFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;

class CategoryController extends AdminCrudAbstract {
    
    /**
     * @var ContentFinder 
     */
    protected $finder;
    
    protected $modelClass = 'jarrus90\Content\Models\Category';
    
    protected $formClass = 'jarrus90\Content\Models\CategoryForm';
    
    protected $searchClass = 'jarrus90\Content\Models\CategorySearch';
    
    /**
     * List of available upload actions
     * 
     * @return array
     */
    public function actions() {
        return [
            'check' => [
                'class' => '\jarrus90\Content\Controllers\CheckAction',
                'query' => $this->finder->getCategoryQuery()
            ],
        ];
    }
    /**
     * @param string  $id
     * @param BaseModule $module
     * @param ContentFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, ContentFinder $finder, $config = []) {
        $this->finder = $finder;
        Yii::$app->view->params['breadcrumbs'][] = Yii::t('content', 'Content');
        Yii::$app->view->params['breadcrumbs'][] = Yii::t('content', 'Categories');
        parent::__construct($id, $module, $config);
    }

    protected function getItem($id) {
        return $this->finder->findCategory(['id' => $id])->one();
    }

}