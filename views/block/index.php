<?php

use yii\web\View;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */
?>
<?php $this->beginContent('@jarrus90/Content/views/_adminLayout.php') ?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'pjax' => true,
    'hover' => true,
    'export' => false,
    'layout' => "{items}{pager}",
    'pager' => ['options' => ['class' => 'pagination pagination-sm no-margin']],
    'columns' => [
        [
            'attribute' => 'key',
            'width' => '40%'
        ],
        [
            'attribute' => 'title',
            'width' => '40%'
        ],
        [
            'attribute' => 'lang_code',
            'width' => '10%'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]);
?>
<?php $this->endContent() ?>
