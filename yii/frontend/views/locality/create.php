<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Locality */

$this->title = 'Create Locality';
$this->params['breadcrumbs'][] = ['label' => 'Localities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locality-create">

    <?= $this->render('_form', [
        'model' => $model,
        'lists' => $lists,
    ]) ?>

</div>
