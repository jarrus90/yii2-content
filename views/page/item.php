<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use jarrus90\Multilang\Models\Language;
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

<?= Html::submitButton(Yii::t('content', 'Save'), ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end() ?>
<?php $this->endContent() ?>
