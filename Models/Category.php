<?php

namespace jarrus90\Content\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\Multilang\Models\Language;

/**
 * Category data model
 *
 * @property int $id Category item primary key
 * @property string $key Category key
 * @property string $title Category title
 * @property string $description Category description
 * @property string $lang_code Category language
 * 
 * @property-write Category $item Category item
 * 
 * @package jarrus90\Content\models
 */
class Category extends ActiveRecord {

    use \jarrus90\Content\traits\KeyCodeValidateTrait;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_category}}';
    }

    /** @inheritdoc */
    public function scenarios() {
        return [
            'create' => ['key', 'title', 'description', 'lang_code'],
            'update' => ['key', 'title', 'description', 'lang_code'],
            'search' => ['key', 'title', 'lang_code'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'key' => Yii::t('content', 'Key'),
            'title' => Yii::t('content', 'Title'),
            'description' => Yii::t('content', 'Description'),
            'lang_code' => Yii::t('content', 'Language'),
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

    /**
     * @param \jarrus90\Content\Models\Category $item
     */
    public function setItem($item) {
        if ($item instanceof Category) {
            $this->id = $item->id;
            $this->setAttributes($item->getAttributes());
            $this->setIsNewRecord($item->getIsNewRecord());
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

    /** @inheritdoc */
    public function delete() {
        if (parent::delete()) {
            Page::updateAll(['category_key' => null], [
                'category_key' => $this->key,
                'lang_code' => $this->lang_code
            ]);
            return true;
        }
        return false;
    }

}
