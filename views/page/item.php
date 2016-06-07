<?php

/**
 * @var $this  yii\web\View
 * @var $model jarrus90\User\models\Role
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
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
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'content')->textarea() ?>

<?= Html::submitButton(Yii::t('rbac', 'Save'), ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end() ?>
<?php $this->endContent() ?>
