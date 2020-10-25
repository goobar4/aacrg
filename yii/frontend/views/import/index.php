<?php

use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;

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

<p>The file for import should be saved in csv format with UTF 8 encoding. Please use this
<a href="<?= Url::base($schema = true).'/uploads/test.csv'?>" title="">example</a>
a template. Use ; as separtor and do not use ; for any other purposes. The format of the date should be yyyy-mm-dd.</p>