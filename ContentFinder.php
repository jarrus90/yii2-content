<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jarrus90\Content;

use yii\base\Object;
use yii\db\ActiveQuery;

/**
 * ContentFinder provides some useful methods for finding active record models.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
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
