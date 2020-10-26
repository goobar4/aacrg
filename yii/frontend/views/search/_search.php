<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ServiceSearch */
/* @var $form yii\widgets\ActiveForm */

if ($flag == 1) {
    $action = 'vial';
} elseif($flag == 2) {
    $action = 'export';
}

?>

<div class="service-search">

    <?php $form = ActiveForm::begin([
        'action' => [$action],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'container') ?>

    <?= $form->field($model, 'prepType')->dropDownList(
        $options= [
            '',
            'helminth'=>'helminth',	
            'tissue'=>'tissue',	
            'protozoan'=>'protozoan',
            'nosample'=>'nosample',
        ]

    ) ?>

    <?= $form->field($model, 'parasite') ?>

    <?= $form->field($model, 'host') ?>

    <?= $form->field($model, 'place') ?>

    <div class='row'>
    <div class='col-lg-6'>
    <?= $form->field($model, 'from') ?>
    </div>
    <div class='col-lg-6'>
    <?= $form->field($model, 'to') ?>
    </div>
    </div>
    <div id="demo" class="collapse">
    <?= $form->field($model, 'host_genus') ?>

    <?= $form->field($model, 'host_family') ?>
    
    <?= $form->field($model, 'host_order') ?>

    <?= $form->field($model, 'host_class') ?>

    <?= $form->field($model, 'host_phylum') ?>

    <?= $form->field($model, 'parasite_genus') ?>

    <?= $form->field($model, 'parasite_family') ?>
    
    <?= $form->field($model, 'parasite_order') ?>

    <?= $form->field($model, 'parasite_class') ?>

    <?= $form->field($model, 'parasite_phylum') ?>

    <?= $form->field($model, 'age') ?>    
    
    <?= $form->field($model, 'province') ?>

    <?= $form->field($model, 'country') ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', [$action], ['class' => 'btn btn-default']) ?>
        <div id="tbutton" data-toggle="collapse" data-target="#demo" class="btn btn-default">More fields</div>

    </div>

    <?php ActiveForm::end(); ?>

</div>