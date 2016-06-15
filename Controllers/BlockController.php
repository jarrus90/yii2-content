<?php

namespace jarrus90\Content\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Content\ContentFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;

class BlockController extends AdminCrudAbstract {
    
    /**
     * @var ContentFinder 
     */
    protected $finder;
    
    protected $modelClass = 'jarrus90\Content\Models\Block';
    
    protected $formClass = 'jarrus90\Content\Models\Block';
    
    protected $searchClass = 'jarrus90\Content\Models\Block';
    
    /**
     * List of available upload actions
     * 
     * @return array
     */
    public function actions() {
        return [
            'check' => [
                'class' => '\jarrus90\Content\Controllers\CheckAction',
                'query' => $this->finder->getBlockQuery()
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
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Blocks'), 'url' => ['index']];
        parent::__construct($id, $module, $config);
    }
    
    public function actionCreate() {
        Yii::$app->view->title = Yii::t('content', 'Create block');
        return parent::actionCreate();
    }

    public function actionUpdate($id) {
        $item = $this->getItem($id);
        Yii::$app->view->title = Yii::t('content', 'Edit block {title}', ['title' => $item->title]);
        return parent::actionUpdate($id);
    }

    protected function getItem($id) {
        $item = $this->finder->findBlock(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('content', 'The requested block does not exist'));
        }
    }
    
    protected function createModelParams() {
        $params = parent::createModelParams();
        $params['key'] = Yii::$app->request->get('key', NULL);
        $params['lang_code'] = Yii::$app->request->get('lang_code', NULL);
        return $params;
    }
}