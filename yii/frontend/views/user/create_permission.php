<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Access */

$this->title = 'Add permission';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->surname, 'url' => ['view', 'id'=>$model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-create">

     <?= $this->render('_access_form', [
        'model' => $model,
    ]) ?>

</div>