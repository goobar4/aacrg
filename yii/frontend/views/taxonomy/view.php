<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Taxonomy */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Taxonomies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="taxonomy-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-lg-5">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'scientificName',
            'genus',
            'family',
            'order',
            'class',
            'phylum',
        ],
    ]) ?>
    </div>
    </div>

</div>
