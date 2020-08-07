<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Locality */

$this->title = 'Update Locality: ' . $model->localityName;
$this->params['breadcrumbs'][] = ['label' => 'Localities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->localityName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="locality-update">

    <?= $this->render('_form', [
        'model' => $model,
        'lists' => $lists,
    ]) ?>

</div>
