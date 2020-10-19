<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use \kartik\switchinput\SwitchInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Container */
/* @var $form yii\widgets\ActiveForm */

is_null($model->containerStatus) ? $model->containerStatus = true : null;

?>
<div class="container-form">
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(); ?>

            <?= $model->scenario == 'create' ? $form->field($model, 'containerId')->textInput(['maxlength' => true]) : null ?>

            <?= $form->field($model, 'containerType')->textInput(['maxlength' => true])
                ->widget(Select2::classname(), [
                    'data' => $lists['containerType'],
                    'hideSearch' => true,
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>

            <?= $form->field($model, 'prepType')->textInput(['maxlength' => true])
                ->widget(Select2::classname(), [
                    'data' => $lists['prepType'],
                    'hideSearch' => true,
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>

            <?= $form->field($model, 'fixative')->textInput(['maxlength' => true])
                ->widget(Select2::classname(), [
                    'data' => $lists['fixative'],
                    'hideSearch' => true,
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>

            <?= $form->field($model, 'date')->textInput(['maxlength' => true])
                ->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>

            <div id="demo" class="collapse">



                <?= $form->field($model, 'containerStatus')->textInput(['maxlength' => true])
                    ->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'True',
                            'offText' => 'False',
                        ],
                        'value' => $model->containerStatus ? '<span class="badge badge-success">True</span>' : '<span class="badge badge-danger">False</span>',
                    ]);



                ?>

                <?= $form->field($model, 'storage')->textInput(['maxlength' => true])
                    ->widget(Select2::classname(), [
                        'data' => $lists['storage'],
                        'hideSearch' => true,
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <div id="tbutton" data-toggle="collapse" data-target="#demo" class="btn btn-info">More fields</div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div>

        </div>
        <?php $this->registerJs("
            //set cursor in Id input
            $('#container-containerid').focus();
            //toggle additional fields
            $('#tbutton').click(function(){
            var tbutton =$('#tbutton');
            var text= tbutton.html();
            text=='More fields' ? tbutton.html('Less fields') : tbutton.html('More fields');
            });
            ");
        ?>