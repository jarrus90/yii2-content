<?php

namespace jarrus90\Content;

use yii\base\Object;
use yii\db\ActiveQuery;

/**
 * ContentFinder provides some useful methods for finding active record models.
 */
class ContentFinder extends Object {

    /** @var ActiveQuery */
    protected $categoryQuery;

    /** @var ActiveQuery */
    protected $pageQuery;

    /** @var ActiveQuery */
    protected $blockQuery;

    /**
     * @return ActiveQuery
     */
    public function getCategoryQuery() {
        return $this->categoryQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getPageQuery() {
        return $this->pageQuery;
    }

    /**
     * @return ActiveQuery
     */
    public function getBlockQuery() {
        return $this->blockQuery;
    }

    /** @param ActiveQuery $categoryQuery */
    public function setCategoryQuery(ActiveQuery $categoryQuery) {
        $this->categoryQuery = $categoryQuery;
    }

    /** @param ActiveQuery $pageQuery */
    public function setPageQuery(ActiveQuery $pageQuery) {
        $this->pageQuery = $pageQuery;
    }

    /** @param ActiveQuery $blockQuery */
    public function setBlockQuery(ActiveQuery $blockQuery) {
        $this->blockQuery = $blockQuery;
    }

    /**
     * Finds a category by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findCategory($condition) {
        return $this->categoryQuery->where($condition);
    }

    /**
     * Finds a page by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findPage($condition) {
        return $this->pageQuery->where($condition);
    }

    /**
     * Finds a page by the given condition.
     *
     * @param mixed $condition Condition to be used on search.
     *
     * @return \yii\db\ActiveQuery
     */
    public function findBlock($condition) {
        return $this->blockQuery->where($condition);
    }

}
