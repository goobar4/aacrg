<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ContainerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Containers';

if (isset($contoller)){
    $rout = 'deleted-container';
    $this->params['breadcrumbs'][] = ['label' => 'Container', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => 'Trash'];}
    else{
        $this->params['breadcrumbs'][] = $this->title;
        $rout = 'index';
    }

?>
<div class="container-index">

<div class="row">

<div class="col-sm-8">




    <?php
    $gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'contentOptions' => ['class' => 'kartik-sheet-style'],

        ],

        [
            'attribute' => 'containerId',
            'label' => 'containerId',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a(
                    $model->containerId,
                    Url::to(['container/view', 'id' => $model->containerId]),
                    ['data-pjax' => 0]
                );
            },
            'format' => 'raw',
            'vAlign' => 'middle',

        ],


        [
            'attribute' => 'prepType0.value',
            'label' => 'prepType',
            'vAlign' => 'middle',

        ],


        [
            'attribute' => 'containerType0.value',
            'label' => 'containerType',
            'vAlign' => 'middle',

        ],
            
        
        [
            'attribute' => 'parId',
            'label' => 'host id',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a(
                    $model->parId,
                    Url::to(['host/view', 'id' => $model->parId]),
                    ['data-pjax' => 0]
                );
            },
            'format' => 'raw',
            'vAlign' => 'middle',

        ],

        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'containerStatus',
            'label' => 'containerStatus',
            'vAlign' => 'middle',

        ],
        
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '',
            'template' => '{update} {delete} ',
            'buttons' => [
                'update' => function ($url, $model) {
                    $url = Url::to(['container/update', 'id' => $model->containerId]);
                    return Html::a('',  $url, [
                        'class' => 'glyphicon glyphicon-pencil ', 'data-toggle' => 'tooltip', 'title' => 'Edit',
                        'data-pjax' => 0
                    ]);
                },
                'delete' => function ($url, $model) {
                    $url = Url::to(['container/delete', 'id' => $model->containerId]);
                    return Html::a('',  $url, [
                        'class' => 'glyphicon glyphicon-trash ', 'data-toggle' => 'tooltip', 'title' => 'Delete',
                        'method'=>'post',
                        'data-pjax' => 0
                    ]);
                },


            ],

        ],

    ]

    ?>

    <?= GridView::widget([
        'id' => 'cont',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'showPageSummary' => false,
       'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true,                     
        'toolbar' =>  [
            [
                'content' =>
                Html::a('<i  class="glyphicon glyphicon-repeat"></i>', [$rout, 'reset' => '1'], [
                        'class' => 'btn  btn-default',
                        'title' => 'Reset filter',
                        'data-pjax' => 0,
                    ]),
                'options' => ['class' => 'btn-group mr-2']

            ],
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Container',

            'before' => '',
            'after' => false,
        ],
        'persistResize' => false,


    ]);

    ?>


</div>
</div>

</div>
