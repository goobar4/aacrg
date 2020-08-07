<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Storage */

$this->title = 'Create Storage';
$this->params['breadcrumbs'][] = ['label' => 'Storages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
