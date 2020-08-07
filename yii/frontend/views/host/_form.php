<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
//use yii\jui\DatePicker;
use \kartik\switchinput\SwitchInput;
use yii\web\JsExpression;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Host */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="host-form">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(
                [
                    'id' => 'host',
                    'layout' => 'default',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-3',
                            'offset' => 'col-sm-offset-4',
                            'wrapper' => 'col-sm-9',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],


                ]
            );

            //set routs for Select2

            $url_place = \yii\helpers\Url::to(['place-list']);
            $url_taxon = \yii\helpers\Url::to(['taxon-list']);

            $myTime = date("Y-m-d");
            if (empty($model->natureOfRecord)) {
                $model->natureOfRecord = 9;
            }

            ?>

            <?= $form->field($model, 'occurrenceID', ['inputOptions' => ['autocomplete' => 'off']])->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'sciName')->widget(Select2::classname(), [
                'initValueText' => isset($model->sciName0->scientificName) ? $model->sciName0->scientificName : null,
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

            <?= $form->field($model, 'sex')->widget(Select2::classname(), [
                'data' => $lists['sex'],
                'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'age')->widget(Select2::classname(), [
                'data' => $lists['age'],
                'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'natureOfRecord')->widget(Select2::classname(), [
                'data' => $lists['natureOfRecord'],
                'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>

            <?= $form->field($model, 'placeName')->widget(Select2::classname(), [
                'initValueText' => isset($model->placeName0->localityName) ? $model->placeName0->localityName : null,
                'options' => ['placeholder' => '...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url_place,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(placeName) { return placeName.text; }'),
                    'templateSelection' => new JsExpression('function (placeName) { return placeName.text; }'),
                ],
            ]); ?>




            <?= $form->field($model, 'occurenceDate', ['inputOptions' => ['autocomplete' => 'off']])
                ->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
            ?>

            <?= $form->field($model, 'determiner')->textInput()->widget(Select2::classname(), [
                'data' => $lists['determiner'],
                'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'isEmpty', ['inputOptions' => ['autocomplete' => 'off']])->widget(SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'Yes',
                    'offText' => 'No',
                ],
                'value' => $model->isEmpty ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>',



            ]); ?>

            <div id="demo" class="collapse">
                <?= $form->field($model, 'sAIAB_Catalog_Number')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'сonfidence')->textInput(['maxlength' => true, 'value' => 0]) ?>

                <?= $form->field($model, 'comments')->textarea() ?>


            </div>


            <div class="form-group">
                <?= Html::submitButton('Save', ['id' => 'save', 'class' => 'btn btn-success']) ?>
                <div id="tbutton" data-toggle="collapse" data-target="#demo" class="btn btn-info">More fields</div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<?php $this->registerJs("
//set cursor in Id input
$('#host-occurrenceid').focus();
//toggle additional fields
$('#tbutton').click(function(){
  var tbutton =$('#tbutton');
  var text= tbutton.html();
  text=='More fields' ? tbutton.html('Less fields') : tbutton.html('More fields');
});

");
?>
