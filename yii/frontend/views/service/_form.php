<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">
    <div class="row">

        <div class="col-sm-4">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'target')->textInput(['maxlength' => true])->dropDownList(
                [
                    'sex' => 'sex',
                    'age' => 'age',
                    'natureOfRecord' => 'natureOfRecord',
                    'typeStatus' => 'typeStatus',
                    'featureOrBasis' => 'featureOrBasis',
                    'containerType' => 'containerType',
                    'fixative' => 'fixative',
                    'basisOfRecord' => 'basisOfRecord',
                    'province' => 'province',
                    'country' => 'country',
                    'island' => 'island',
                    'site'=>'site',

                ],
                $params = [
                    'prompt' => ''
                ]
                
            ); ?>
            <?= $form->field($model, '_table')->textInput(['maxlength' => true])->dropDownList(
                [
                    'host' => 'host',
                    'container' => 'container',
                    'sample' => 'sample',
                    'locality' => 'locality',

                ],
                $params = [
                    'prompt' => ''
                ]
            ); ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>