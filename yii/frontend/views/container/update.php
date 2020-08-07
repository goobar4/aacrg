<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Container */

$this->title = 'Update Container: ' . $model->containerId;
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => $model->parId, 'url' => ['host/view', 'id' => $model->parId]];
$this->params['breadcrumbs'][] = ['label' => $model->containerId, 'url' => ['view', 'id' => $model->containerId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-update">

    <?= $this->render('_form', [
        'model' => $model,
        'lists'=>$lists,
    ]) ?>

</div>
