<?php

namespace jarrus90\Content\controllers;

use Yii;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;

class CheckAction extends Action {

    public $query;
    
    public function init() {
        if(empty($this->query)) {
            throw new InvalidConfigException('"query" param must be set');
        } else if(!$this->query instanceof ActiveQuery){
            throw new InvalidConfigException('"query" param must variable og type ActiveQuery');
        }
    }

    public function run() {
        $list = [];
        $listKeys = $this->query->select(['key', 'lang_code'])->asArray()->all();
        $listLangs = \jarrus90\Multilang\Models\Language::listMap();
        foreach($listKeys AS $item){
            if(empty($list[$item['key']])) {
                $list[$item['key']] = [];
            }
            $list[$item['key']][$item['lang_code']] = $item['lang_code'];
        }
        foreach($list AS $key => $elem) {
            $res = array_diff_key($listLangs, $elem);
            if(count($res) == 0 ){
                unset($list[$key]);
            } else {
                $list[$key] = $res;
            }
        }
        return Yii::$app->controller->render('check', [
            'list' => $list
        ]);
    }

}
