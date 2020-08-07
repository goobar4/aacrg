<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Modelhistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modelhistory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'table')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'old_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'new_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
