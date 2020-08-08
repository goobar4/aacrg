<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model frontend\models\Locality */
/* @var $form yii\widgets\ActiveForm */

$flag = Url::current()== Url::toRoute('locality/renderajax') ? true : false;

?>

<div class="locality-form">

<?php 
If ($flag == false){
  echo ' <div class="row"> <div class="col-lg-5">';}

    $form = ActiveForm::begin(
         [
            //'action' => '/index.php?r=locality%2Fcreate',
            'id' => 'loc'
        ]
    ); ?>

    <?= $form->field($model, 'localityName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->widget(Select2::classname(), [
                'data' => $lists['province'],
                //'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'country')->widget(Select2::classname(), [
                'data' => $lists['country'],
                //'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'decimalLatitude')->textInput() ?>

    <?= $form->field($model, 'decimalLongitude')->textInput() ?>

    <?= $form->field($model, 'island')->widget(Select2::classname(), [
                'data' => $lists['island'],
                //'hideSearch' => true,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'cordMethod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'elevation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'typeHabitate')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success'],['id'=>'1']) ?>
    
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
<?php 
If ($flag == true){
$this->registerJs("

var loader = '<div class=\"loader\">';



$('#loc').on('beforeSubmit', function(){
    var data = $(this).serialize();
    $('#myModal').find('#main').empty();
    $('#myModal').find('#main').append(loader);
    $.ajax({
    url: '".Url::toRoute(['locality/create'], $schema = true)."',
    type: 'POST',
    data: data,
    success: function(res){
    
    if(res.res=='error'){
        //alert('Error of validation.');
        $('#myModal').modal();        
        $('#myModal').find('.modal-body').load('".Url::toRoute(['locality/renderajax'], $schema = true)."');
    }
        else{
            
           
            //location.reload();
            //$('#host').submit();
            $('#myModal').modal('hide');
            
            
            
        }
    },
    
    error: function(){
        alert('server error');
    }
    });
    return false;
    });


");
}
?>