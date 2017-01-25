<?php

namespace jarrus90\Content\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\Multilang\Models\Language;

/**
 * Block data model
 *
 * @property int $id Block item primary key
 * @property string $key Block key
 * @property string $title Block title
 * @property string $content Block content
 * @property string $lang_code Block language
 *
 * @property-write Block $item Block item
 *
 * @package jarrus90\Content\Models
 */
class Block extends ActiveRecord {

    use \jarrus90\Content\traits\KeyLangValidateTrait;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%content_block}}';
    }
    
    /** @inheritdoc */
    public function scenarios() {
        return [
            'create' => ['key', 'title', 'content', 'lang_code'],
            'update' => ['key', 'title', 'content', 'lang_code'],
            'search' => ['key', 'title', 'lang_code'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels(){
        return [
            'key' => Yii::t('content', 'Key'),
            'title' => Yii::t('content', 'Title'),
            'content' => Yii::t('content', 'Content'),
            'lang_code' => Yii::t('content', 'Language'),
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['key', 'title', 'content', 'lang_code'], 'required', 'on' => ['create', 'update']],
            'keyValid' => ['key', 'validateKeyLangPair', 'on' => ['create', 'update']],
            'langExists' => ['lang_code', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'code'],
            'safeSearch' => [['key', 'title', 'lang_code'], 'safe', 'on' => ['search']],
        ];
    }

    /**
     * @param \jarrus90\Content\Models\Block $item
     */
    public function setItem($item) {
        if ($item instanceof Block) {
            $this->id = $item->id;
            $this->setAttributes($item->getAttributes());
            $this->setIsNewRecord($item->getIsNewRecord());
        }
    }

    /**
     * Search blocks list
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['id' => $this->id]);
            $query->andFilterWhere(['lang_code' => $this->lang_code]);
            $query->andFilterWhere(['like', 'key', $this->key]);
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['like', 'content', $this->content]);
        }
        return $dataProvider;
    }

}
