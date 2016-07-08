<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use jarrus90\Multilang\Models\Language;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@jarrus90/Content/views/_adminLayout.php') ?>

<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-9',
                ],
            ],
        ])
?>

<?= $form->field($model, 'key') ?>
<?= $form->field($model, 'lang_code')->widget(Select2::className(), [
    'theme' => 'default',
    'data' => Language::listMap(),
    'pluginEvents' => [
        "change" => "function() { $('#page-category_key').val('').trigger('change'); }",
    ],
    'options' => [
        'placeholder' => Yii::t('content', 'Select language'),
    ],
]);
?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'content')->widget(\jarrus90\Content\Widgets\Redactor::className(), [
    'clientOptions' => [
        'lang' => Yii::$app->language,
        'minHeight' => 200,
        'plugins' => [
            'fontsize',
            'fontcolor',
            'fontfamily',
            'table',
            'counter',
            'fullscreen',
            'imagemanager'
        ],
    ]
])
?>
<?= $form->field($model, 'category_key')->widget(Select2::className(), [
    'theme' => 'default',
    'pluginOptions' => [
        'ajax' => [
            'url' => Url::toRoute('/content/category/list'),
            'dataType' => 'json',
            'delay' => 50,
            'data' => new JsExpression('function(params) { return {lang: $(\'#page-lang_code\').val()}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function (procedure) { return procedure.text; }'),
        'templateSelection' => new JsExpression('function (procedure) { return procedure.text; }'),
    ],
    'options' => [
        'placeholder' => Yii::t('support', 'Select category'),
    ],
]);
?>

<?= Html::submitButton(Yii::t('content', 'Save'), ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end() ?>
<?php $this->endContent() ?>
