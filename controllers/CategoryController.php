<?php

namespace jarrus90\Content\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\base\Module as BaseModule;
use jarrus90\Content\ContentFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;

/**
 * @package jarrus90\Content\controllers
 */

class CategoryController extends AdminCrudAbstract {

    /**
     * @var ContentFinder 
     */
    protected $finder;
    protected $modelClass = 'jarrus90\Content\Models\Category';
    protected $formClass = 'jarrus90\Content\Models\Category';
    protected $searchClass = 'jarrus90\Content\Models\Category';

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['content_publisher'],
                    ],
                ],
            ],
        ];
    }

    /**
     * List of available upload actions
     * 
     * @return array
     */
    public function actions() {
        return [
            'check' => [
                'class' => '\jarrus90\Content\controllers\CheckAction',
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
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::$app->view->title = Yii::t('content', 'Categories');
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('content', 'Content');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Categories'), 'url' => ['index']];
            return true;
        }
        return false;
    }

    /** @inheritdoc */
    public function actionCreate() {
        Yii::$app->view->title = Yii::t('content', 'Create category');
        return parent::actionCreate();
    }

    /** @inheritdoc */
    public function actionUpdate($id) {
        $item = $this->getItem($id);
        Yii::$app->view->title = Yii::t('content', 'Edit category {title}', ['title' => $item->title]);
        return parent::actionUpdate($id);
    }

    /** @inheritdoc */
    protected function getItem($id) {
        $item = $this->finder->findCategory(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('content', 'The requested category does not exist'));
        }
    }

    /** @inheritdoc */
    protected function createModelParams() {
        $params = parent::createModelParams();
        $params['key'] = Yii::$app->request->get('key', NULL);
        $params['lang_code'] = Yii::$app->request->get('lang_code', NULL);
        return $params;
    }

    
    public function actionList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = $this->finder->findCategory(['lang_code' => Yii::$app->request->get('lang')])->asArray()->all();
        $result = [];
        foreach($items AS $item){
            $result[] = [
                'id' => $item['key'],
                'text' => $item['title'],
            ];
        }
        return ['results' => $result];
    }

}
