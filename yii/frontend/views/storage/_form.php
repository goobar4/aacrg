<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Storage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storage-form">
    <div class="row">

        <div class="col-sm-4">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'item1')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'item2')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'item3')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'item4')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'item5')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'item6')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'item7')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>