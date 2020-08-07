<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Sample */
/* @var $form yii\widgets\ActiveForm */

//set routs for Select2

$url_taxon = \yii\helpers\Url::to(['taxon-list']);
?>

<div class="sample-form">
    <div class="row">

        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'scienName')->textInput()->widget(Select2::classname(), [
                'initValueText' => isset($model->scienName0->scientificName) ? $model->scienName0->scientificName : null,
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
                    'templateResult' => new JsExpression('function(sciName) { return sciName.text; }'),
                    'templateSelection' => new JsExpression('function (sciName) { return sciName.text; }'),
                ],
            ]); ?>

            <?= $form->field($model, 'individualCount')->textInput() ?>

            <?= $form->field($model, 'site')->textInput()
                    ->widget(Select2::classname(), [
                        'data' => $lists['site'],
                        //'hideSearch' => true,
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
            ]); ?>

            <?= $form->field($model, 'remarks')->textarea(); ?>

            <?php /* $form->field($model, 'sex')->widget(Select2::classname(), [
                'data' => $lists['sex'],
                'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); */ ?>

            <?= $form->field($model, 'identifiedBy')->textInput()
                ->widget(Select2::classname(), [
                    'data' => $lists['identifiedBy'],
                    'hideSearch' => true,
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            <div id="demo" class="collapse">

                <?= $form->field($model, 'basisOfRecord')->textInput()
                    ->widget(Select2::classname(), [
                        'data' => $lists['basisOfRecord'],
                        //'hideSearch' => true,
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                <?= $form->field($model, 'typeStatus')->textInput()
                    ->widget(Select2::classname(), [
                        'data' => $lists['typeStatus'],
                        //'hideSearch' => true,
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                              
                <?= $form->field($model, 'qualifier')->textInput() ?>

                <?= $form->field($model, 'confidence')->textInput() ?>

            </div>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success'], ['id' => '1']) ?>
                <div id="tbutton" data-toggle="collapse" data-target="#demo" class="btn btn-info">More fields</div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php $this->registerJs("

//toggle additional fields
$('#tbutton').click(function(){
  var tbutton =$('#tbutton');
  var text= tbutton.html();
  text=='More fields' ? tbutton.html('Less fields') : tbutton.html('More fields');
});

");
?>