<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Host */

$this->title = 'Update Host: ' . $model->occurrenceID;
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->occurrenceID, 'url' => ['view', 'id' => $model->occurrenceID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="host-update">

    
    <?= $this->render('_form', [
         'model' => $model,
         'lists' => $lists
    ]) ?>

</div>
