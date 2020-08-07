<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Access */
/* @var $form yii\widgets\ActiveForm */
$url_taxon = \yii\helpers\Url::to(['taxon-list']);
?>

<div class="access-form">
<div class="row">
        <div class="col-lg-5">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'taxon_id')->widget(Select2::classname(), [
                'initValueText' => isset ($model->taxon->scientificName) ? $model->taxon->scientificName: null,
                'options' => ['placeholder' => '...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url_taxon,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(placeName) { return placeName.text; }'),
                    'templateSelection' => new JsExpression('function (placeName) { return placeName.text; }'),
                ],
            ]); ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
    </div>

</div>