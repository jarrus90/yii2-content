<?php

namespace jarrus90\Content\controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Content\ContentFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;
use yii\filters\AccessControl;

/**
 * @package jarrus90\Content\controllers
 */

class PageController extends AdminCrudAbstract {

    /**
     *
     * @var ContentFinder 
     */
    protected $finder;
    protected $modelClass = 'jarrus90\Content\Models\Page';
    protected $formClass = 'jarrus90\Content\Models\Page';
    protected $searchClass = 'jarrus90\Content\Models\Page';

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
                'query' => $this->finder->getPageQuery()
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
    
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::$app->view->title = Yii::t('content', 'Pages');
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('content', 'Content');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Pages'), 'url' => ['index']];
            return true;
        }
        return false;
    }

    public function actionCreate() {
        Yii::$app->view->title = Yii::t('content', 'Create page');
        return parent::actionCreate();
    }

    public function actionUpdate($id) {
        $item = $this->getItem($id);
        Yii::$app->view->title = Yii::t('content', 'Edit page {title}', ['title' => $item->title]);
        return parent::actionUpdate($id);
    }

    protected function getItem($id) {
        $item = $this->finder->findPage(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('content', 'The requested page does not exist'));
        }
    }

    protected function createModelParams() {
        $params = parent::createModelParams();
        $params['key'] = Yii::$app->request->get('key', NULL);
        $params['lang_code'] = Yii::$app->request->get('lang_code', NULL);
        return $params;
    }

}
