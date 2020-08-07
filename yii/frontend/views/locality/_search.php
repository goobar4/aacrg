<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\LocalitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="locality-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?/* $form->field($model, 'id') */?>

    <?= $form->field($model, 'localityName') ?>

    <?= $form->field($model, 'province') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'decimalLatitude') ?>

    <?php // echo $form->field($model, 'decimalLongitude') ?>

    <?php // echo $form->field($model, 'typeHabitate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
