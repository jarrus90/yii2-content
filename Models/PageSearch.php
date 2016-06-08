<?php

namespace jarrus90\Content\Models;

use Yii;

class PageSearch extends Page {

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            [['key', 'title'], 'safe'],
        ];
    }

    /**
     * Attribute labels
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'key' => \Yii::t('content', 'Page key'),
            'title' => \Yii::t('content', 'Title'),
        ];
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
        }
        return $dataProvider;
    }

}
