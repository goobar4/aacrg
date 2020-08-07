<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
    'options' => [
    'accept' => 'image/*',
    'multiple' => true],
    ]
);
    
?>   
<?php ActiveForm::end() ?>