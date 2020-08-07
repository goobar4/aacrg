<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\StorageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'item1') ?>

    <?= $form->field($model, 'item2') ?>

    <?= $form->field($model, 'item3') ?>

    <?= $form->field($model, 'item4') ?>

    <?php // echo $form->field($model, 'item5') ?>

    <?php // echo $form->field($model, 'item6') ?>

    <?php // echo $form->field($model, 'item7') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
