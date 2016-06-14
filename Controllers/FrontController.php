<?php

namespace jarrus90\Content\Controllers;

use Yii;
use jarrus90\Content\ContentFinder;
use jarrus90\Core\Web\Controllers\FrontController as Controller;

class FrontController extends Controller {

    /**
     * @var ContentFinder 
     */
    protected $finder;

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

    public function actionPage($key) {
        $lang = Yii::$app->request->get('lang', Yii::$app->language);
        $page = $this->finder->findPage([
            'key' => $key,
            'lang_code' => $lang
        ])->one();
        return $this->render('page', [
            'page' => $page
        ]);
    }

}
