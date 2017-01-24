<?php

namespace jarrus90\Content\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\Multilang\Models\Language;

/**
 * Page data model
 *
 * @property int $id Page item primary key
 * @property string $key Page key
 * @property string $title Page title
 * @property string $content Page content
 * @property string $lang_code Page language
 *
 * @property string $meta_keywords Page Meta keywords
 * @property string $meta_description Page Meta description
 *
 * @property-write \jarrus90\Content\Models\Page $item Page item
 *
 * @package jarrus90\Content\models
 */
class Page extends ActiveRecord {

    use \jarrus90\Content\traits\KeyCodeValidateTrait;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_page}}';
    }

    /** @inheritdoc */
    public function scenarios() {
        return [
            'create' => ['key', 'title', 'content', 'lang_code', 'category_key', 'meta_keywords', 'meta_description'],
            'update' => ['key', 'title', 'content', 'lang_code', 'category_key', 'meta_keywords', 'meta_description'],
            'search' => ['key', 'title', 'lang_code', 'category_key'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'key' => Yii::t('content', 'Key'),
            'title' => Yii::t('content', 'Title'),
            'content' => Yii::t('content', 'Content'),
            'lang_code' => Yii::t('content', 'Language'),
            'meta_keywords' => Yii::t('content', 'Meta keywords'),
            'meta_description' => Yii::t('content', 'Meta description'),
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
            'categoryExists' => ['category_key', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'key'],
            'metaSafe' => [['meta_keywords', 'meta_description'], 'safe', 'on' => ['create', 'update']],
        ];
    }

    /**
     * @param \jarrus90\Content\Models\Page $item
     */
    public function setItem($item) {
        if ($item instanceof Page) {
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

}
