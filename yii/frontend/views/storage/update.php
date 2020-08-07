<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Storage */

$this->title = 'Update Storage: ' . $model->item1;
$this->params['breadcrumbs'][] = ['label' => 'Storages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item1, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="storage-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
