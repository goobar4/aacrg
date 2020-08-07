<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Access */

$this->title = 'Update Permission';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->surname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update Permission';
?>
<div class="access-update">

     <?= $this->render('_access_form', [
        'model' => $model,
    ]) ?>

</div>