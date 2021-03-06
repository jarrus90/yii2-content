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

class BlockController extends AdminCrudAbstract {
    
    /**
     * @var ContentFinder 
     */
    protected $finder;

    /** @inheritdoc */
    protected $modelClass = 'jarrus90\Content\Models\Block';

    /** @inheritdoc */
    protected $formClass = 'jarrus90\Content\Models\Block';

    /** @inheritdoc */
    protected $searchClass = 'jarrus90\Content\Models\Block';

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
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::$app->view->title = Yii::t('content', 'Blocks');
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('content', 'Content');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('content', 'Blocks'), 'url' => ['index']];
            return true;
        }
        return false;
    }

    /** @inheritdoc */
    public function actionCreate() {
        Yii::$app->view->title = Yii::t('content', 'Create block');
        return parent::actionCreate();
    }

    /** @inheritdoc */
    public function actionUpdate($id) {
        $item = $this->getItem($id);
        Yii::$app->view->title = Yii::t('content', 'Edit block {title}', ['title' => $item->title]);
        return parent::actionUpdate($id);
    }

    /**
     * Get block item
     * @param type $id
     * @return Block
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getItem($id) {
        $item = $this->finder->findBlock(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('content', 'The requested block does not exist'));
        }
    }

    /** @inheritdoc */
    protected function createModelParams() {
        $params = parent::createModelParams();
        $params['key'] = Yii::$app->request->get('key', NULL);
        $params['lang_code'] = Yii::$app->request->get('lang_code', NULL);
        return $params;
    }
}