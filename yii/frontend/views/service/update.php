<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Service */

$this->title = 'Update Service: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-update">

  
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
