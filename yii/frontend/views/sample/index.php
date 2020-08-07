<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SampleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Samples';
if (isset($contoller)) {
    $this->params['breadcrumbs'][] = ['label' => 'Sample', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => 'Trash'];
    $rout = 'deleted-sample';
} elseif (isset($collection)) {
    $this->title = 'Collection';
    $this->params['breadcrumbs'][] = $this->title;
    $rout = 'collection';
} else {
    $this->params['breadcrumbs'][] = $this->title;
    $rout = 'index';
}

?>

<div class="sample-index">
    <div class="row">
        <div class="col-sm-8">

            <?php
            $gridColumns = [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],

                ],

                [
                    'attribute' => 'species',
                    'value' => function ($model, $key, $index, $widget) {
                        return Html::a(
                            $model['species'],
                            Url::to(['sample/view', 'id' => $model['ident']]),
                            ['data-pjax' => 0]
                        );
                    },
                    'format' => 'raw',
                    'vAlign' => 'middle',

                ],

                /*[
                    'attribute' => 'sex',
                    'label' => 'sex',

                    'vAlign' => 'middle',

                ],*/

                [
                    'attribute' => 'indCount',
                    'vAlign' => 'middle',

                ],

                [
                    'class' => 'kartik\grid\BooleanColumn',
                    'label' => 'My collection',
                    'attribute' => 'collection',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model['collection'] ? $model['collection'] : '';
                    },

                    'format' => 'raw'

                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '',
                    'template' => '{info}',
                    'buttons' => [
                        'info' => function ($url, $model) {
                            if ($model['collection']) {
                                $url = Url::to(['sample/remove-collection', 'id' => $model['ident']]);
                                return Html::a('',  $url, ['class' => 'glyphicon glyphicon-remove ', 'data-toggle' => 'tooltip', 'title' => 'Remove from collection']);
                            } else {
                                $url = Url::to(['sample/add-collection', 'id' => $model['ident']]);
                                return Html::a('',  $url, ['class' => 'glyphicon glyphicon-paperclip ', 'data-toggle' => 'tooltip', 'title' => 'Add to collection']);
                            }
                        },



                    ],

                ],

                [
                    'attribute' => 'container',
                    'value' => function ($model, $key, $index, $widget) {
                        return Html::a(
                            $model['container'],
                            Url::to(['container/view', 'id' => $model['container']]),
                            ['data-pjax' => 0]
                        );
                    },
                    'vAlign' => 'middle',
                    'format' => 'raw'

                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '',
                    'template' => '{update} {delete} ',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $url = Url::to(['sample/update', 'id' => $model['ident']]);
                            return Html::a('',  $url, [
                                'class' => 'glyphicon glyphicon-pencil ', 'data-toggle' => 'tooltip', 'title' => 'Edit',
                                'data-pjax' => 0
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            $url = Url::to(['sample/delete', 'id' => $model['ident']]);
                            return Html::a('',  $url, [
                                'class' => 'glyphicon glyphicon-trash ', 'data-toggle' => 'tooltip', 'title' => 'Delete',
                                'data-pjax' => 0
                            ]);
                        },


                    ],

                ],

            ]

            ?>

            <?= GridView::widget([
                'id' => 'sample',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'showPageSummary' => false,
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => true,
                //'toggleDataContainer' => ['class' => 'btn-group mr-2'],          
                'toolbar' =>  [
                    [
                        'content' =>
                        Html::a('<i  class="glyphicon glyphicon-repeat"></i>', [$rout, 'reset' => '1'], [
                            'class' => 'btn  btn-default',
                            'title' => 'Reset',
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
                    'heading' => 'Samples',

                    'before' => '',
                    'after' => false,
                ],
                'persistResize' => false,


            ]);
            ?>
        </div>
    </div>
</div>