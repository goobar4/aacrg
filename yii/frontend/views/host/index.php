<?php


//use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hosts';


if (isset($contoller)) {
    $rout ='deleted-host';
    $this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => 'Trash'];
} else {
    $rout = 'index';
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="host-index">

    <div class="row">

        <div class="col-sm-9">




            <?php
            $gridColumns = [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],

                ],

                [
                    'attribute' => 'occurrenceID',
                    'label' => 'occurrenceID',
                    'value' => function ($model, $key, $index, $widget) {
                        return Html::a(
                            $model->occurrenceID,
                            Url::to(['host/view', 'id' => $model->occurrenceID]),
                            ['data-pjax' => 0]
                        );
                    },
                    'format' => 'raw',
                    'vAlign' => 'middle',

                ],


                [
                    'attribute' => 'sciName0.scientificName',
                    'label' => 'Name',
                    'vAlign' => 'middle',

                ],


                [
                    'attribute' => 'sexValue.value',
                    'label' => 'sex',
                    'vAlign' => 'middle',

                ],
                [
                    'attribute' => 'ageValue.value',
                    'label' => 'life stage',
                    'vAlign' => 'middle',

                ],

                [
                    'attribute' => 'placeName0.localityName',
                    'label' => 'locality',
                    'vAlign' => 'middle',

                ],

                [
                    'attribute' => 'occurenceDate',
                    'label' => 'date',
                    'vAlign' => 'middle',

                ],

                [
                    'class' => 'kartik\grid\BooleanColumn',
                    'attribute' => 'isEmpty',
                    'label' => 'isEmpty',
                    'vAlign' => 'middle',

                ],

                [
                    'attribute' => 'editedAt',
                    'vAlign' => 'middle',
                    'format' => 'date'

                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '',
                    'template' => '{update} {delete} ',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $url = Url::to(['host/update', 'id' => $model->occurrenceID]);
                            return Html::a('',  $url, [
                                'class' => 'glyphicon glyphicon-pencil ', 'data-toggle' => 'tooltip', 'title' => 'Edit',
                                'data-pjax' => 0
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            $url = Url::to(['host/delete', 'id' => $model->occurrenceID]);
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
                'id' => 'host',
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
                        Html::a(
                            '<i  class="glyphicon glyphicon-plus"></i>', ['create'],
                            [
                                'class' => 'btn  btn-success',
                                'title' => 'Create host',
                                'data-pjax' => 0,
                            ]
                        ) . '' .
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
                    'heading' => 'Hosts',

                    'before' => '',
                    'after' => false,
                ],
                'persistResize' => false,


            ]);

            ?>


        </div>
    </div>
</div>