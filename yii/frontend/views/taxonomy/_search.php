<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TaxonomySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="taxonomy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'scientificName') ?>

    <?= $form->field($model, 'genus') ?>

    <?= $form->field($model, 'family') ?>

    <?= $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'phylum') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
