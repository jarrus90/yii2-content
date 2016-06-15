<?php

namespace jarrus90\Content\Models;

use yii\db\ActiveRecord;
use jarrus90\Multilang\Models\Language;
class Block extends ActiveRecord {

    use \jarrus90\Content\traits\KeyCodeValidateTrait;
    /**
     * @var Block 
     */
    public $item;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_block}}';
    }

    public function scenarios() {
        return [
            'create' => ['key', 'title', 'content', 'lang_code'],
            'update' => ['key', 'title', 'content', 'lang_code'],
            'search' => ['key', 'title', 'lang_code'],
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['key', 'title', 'content', 'lang_code'], 'required', 'on' => ['create', 'update']],
            'keyValid' => ['key', 'validateKeyCodePair', 'on' => ['create', 'update']],
            'langExists' => ['lang_code', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'code'],
            'safeSearch' => [['key', 'title', 'lang_code'], 'safe', 'on' => ['search']],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if ($this->item instanceof Block) {
            $this->setIsNewRecord($this->item->getIsNewRecord());
            if (!$this->isNewRecord) {
                $this->id = $this->item->id;
                $this->setOldAttribute('id', $this->item->id);
            }
            $this->key = $this->item->key;
            $this->title = $this->item->title;
            $this->content = $this->item->content;
            $this->lang_code = $this->item->lang_code;
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
