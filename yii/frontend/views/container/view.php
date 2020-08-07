<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Container */

$this->title = $model->containerId;
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['host/index']];
$this->params['breadcrumbs'][] = ['label' => $model->parId, 'url' => Url::to(['host/view', 'id' => $model->parId])];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$history = Html::a('   ', Url::to(['host/history', 'id' => $model->containerId, 'table'=>'container']), $options = [
    'class' => 'glyphicon glyphicon-list-alt kv-action-btn', 'data-toggle' => 'tooltip', 'title' => 'History'
]);
$add_container = Html::a('', Url::to(['sample/create', 'id' => $model->containerId, 'back'=>$model->parId]),  $option = [
    'class' => 'glyphicon glyphicon-plus kv-action-btn', 'data-toggle' => 'tooltip', 'title' => 'Add new sample'
]);

$restore = Html::a('Restore', Url::to(['container/restore', 'id' => $model->containerId]));
$delete = Html::a('Permanent removal', ['delete', 'id' => $model->containerId], [
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
]);
?>
<div class="container-view">
    <?php if ($model->isDeleted == 1) { ?>
        <div class="alert alert-danger">
            <strong>Deleted!</strong> This record is deleted. Actions: <?= $restore ?> or <?= $delete ?>.
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-6">

            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'bordered' => true,
                'striped' => false,
                'hideIfEmpty' => true,
                'hideAlerts' => true,
                'mode' => DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => 'Container # ' . $model->containerId,
                    'type' => DetailView::TYPE_INFO,
                    'footer' => 
                    '<div class="text-left text-muted">' . $history .'</div>'
                ],
                'deleteOptions' => [ // your ajax delete parameters
                    'params' => ['id' => 1, 'kvdelete' => true],
                ],
                'container' => ['id' => 'host-view'],
                'formOptions' => ['action' => Url::current()],
                'attributes' => [

                    [
                        'attribute' => 'containerType',
                        'value' => isset($model->containerType0->value) ? $model->containerType0->value: null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['containerType'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],


                    ],
                    [
                        'attribute' => 'prepType',
                        'value' => isset($model->prepType0->value) ? $model->prepType0->value : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['prepType'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],

                    ],
                    [
                        'attribute' => 'fixative',
                        'value' => isset($model->fixative0->value) ? $model->fixative0->value : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['fixative'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],

                    ],
                    [
                        'attribute' => 'storage',
                        'format'=>'raw',
                        'value'=>isset($model->storage0->item1) ? Html::a(
                            $model->storage0->item1, 
                            Url::to(['storage/view', 'id'=>$model->storage0->id]),
                             ['class'=>'kv-author-link']) : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['storage'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],

                    ],
                [
                    'attribute' => 'date',
                    'value' => $model->date,
                    'type' => DetailView::INPUT_DATE,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ],

                ],
                    [
                        'attribute' => 'comment',
                        'type' => DetailView::INPUT_TEXTAREA,

                    ],
                    [
                        'attribute' => 'containerStatus',
                        'format' => 'raw',
                        'type' => DetailView::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'True',
                                'offText' => 'False',
                            ]
                        ],
                        'value' => $model->containerStatus ? '<span class="badge badge-success">True</span>' : '<span class="badge badge-danger">False</span>',
                    ],

                ]
            ]); ?>


        </div>
        <div class="col-lg-3">
        <!-- if model has empty status do not show table for child-->
        <?php if ($model->prepType !== '21') { ?>
        
            <div class='kv-view-mode'>
            <table class="kv-view-mode table table-bordered table-hover" id="111">
                <thead class='panel panel-info'>
                    <tr class='panel-heading'>

                        <th class='panel-title'>species  <?= $add_container ?></th>
                        <th class='panel-title'>amount</th>
                       <!-- <th class='panel-title'>sex</th>-->
                    </tr>
                </thead>
                <tbody class='kv-detail-view table-responsive table table-hover table-bordered detail-view'>
                    <?php foreach ($sample as $d) { ?>
                        <tr>
                            <td><a href="<?= Url::to(['sample/view', 'id' => $d->id]) ?>"><?= $d->scienName0->scientificName ?></a></td>
                            <td> <?= $d->individualCount ?></td>
                            <!--<td> <? //$d->sex0->value ?></td>-->
                        <tr>


                        <?php } ?>

                <tbody>
            </table>
            <?php } ?>
        </div>
        
    </div>
</div>