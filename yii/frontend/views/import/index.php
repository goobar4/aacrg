<?php

use yii\widgets\ActiveForm;
use kartik\file\FileInput;

?>
<h1>Import</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->widget(FileInput::classname(), [
    'options' => [

        'multiple' => false,
    ],

    'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => true,
    ],
]);

?>
<?php ActiveForm::end() ?>