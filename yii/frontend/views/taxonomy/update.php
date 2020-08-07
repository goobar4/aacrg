<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Taxonomy */

$this->title = 'Update: ' . $model->scientificName;
$this->params['breadcrumbs'][] = ['label' => 'Taxons', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="taxonomy-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

</div>
