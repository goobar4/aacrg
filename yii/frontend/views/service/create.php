<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Service */

$this->title = 'Create Service';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-create">

     <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
