<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Locality */

$this->title = $model->localityName;
$this->params['breadcrumbs'][] = ['label' => 'Localities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="locality-view">

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

                    'localityName',
                    [
                        'attribute' => 'province0.value',
                        'label' => 'Province',

                    ],
                    [
                        'attribute' => 'country0.value',
                        'label' => 'Country',

                    ],
                    'decimalLatitude',
                    'decimalLongitude',
                    [
                        'attribute' => 'island0.value',
                        'label' => 'Island',

                    ],
                    'cordMethod',
                    'datum',
                    'elevation',
                    'typeHabitate',
                ],
            ]) ?>
        </div>
    </div>
</div>