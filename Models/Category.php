<?php

namespace jarrus90\Content\Models;

use yii\db\ActiveRecord;
use jarrus90\Multilang\Models\Language;
class Category extends ActiveRecord {

    use \jarrus90\Content\traits\KeyCodeValidateTrait;
    /**
     * @var Category 
     */
    protected $item;
    
    public function setItem($item){
        $this->item = $item;
    }

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_category}}';
    }

    public function scenarios() {
        return [
            'create' => ['key', 'title', 'description', 'lang_code'],
            'update' => ['key', 'title', 'description', 'lang_code'],
            'search' => ['key', 'title', 'lang_code'],
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['key', 'title', 'description', 'lang_code'], 'required', 'on' => ['create', 'update']],
            'keyValid' => ['key', 'validateKeyCodePair', 'on' => ['create', 'update']],
            'langExists' => ['lang_code', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'code'],
            'safeSearch' => [['key', 'title', 'lang_code'], 'safe', 'on' => ['search']],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if ($this->item instanceof Category) {
            $this->id = $this->item->id;
            $this->setAttributes($this->item->getAttributes());
            $this->setIsNewRecord($this->item->getIsNewRecord());
        }
    }

    /**
     * Search categories list
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'key', $this->key]);
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['lang_code' => $this->lang_code]);
        }
        return $dataProvider;
    }

}
