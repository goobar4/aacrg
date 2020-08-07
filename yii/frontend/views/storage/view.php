<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Storage */

$this->title = $model->item1;
$this->params['breadcrumbs'][] = ['label' => 'Storages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="storage-view">

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

        <div class="col-sm-6">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id',
                    'item1',
                    'item2',
                    'item3',
                    'item4',
                    'item5',
                    'item6',
                    'item7',
                ],
            ]) ?>

        </div>
    </div>
</div>