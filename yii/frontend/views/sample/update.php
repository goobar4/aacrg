<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Sample */

$this->title = 'Update Sample: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $back, 'url' => Url::to(['container/view', 'id' => $back])];
$this->params['breadcrumbs'][] = ['label' => $model->parId, 'url' => Url::to(['container/view', 'id' => $model->parId])];
$this->params['breadcrumbs'][] = ['label' => $model->scienName0->scientificName, 'url' => Url::to(['sample/view', 'id' => $model->id])];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="sample-update">

    <?= $this->render('_form', [
        'model' => $model,
        'lists' => $lists,
    ]) ?>

</div>
