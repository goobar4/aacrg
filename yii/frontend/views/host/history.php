<?php

use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ModelhistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//public $dataProvider;
//$this->dataProvider = $dataProvider;


//determine name of table

$this->title = 'History of ID: '.$id;
$this->params['breadcrumbs'][] = ['label' =>'Back to: '.$id, 'url' => [$table.'/view', 'id' => $id]];

?>
<div class="modelhistory-index">
    <div class="row">
        <div class="col-sm-10">
            <?php
            $gridColumns = [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],

                ],
                [
                    'attribute' => 'date',
                    'vAlign' => 'middle',

                ],
                [
                    'attribute' => 'field_name',
                    'vAlign' => 'middle',
                ],
                [
                    'attribute' => 'old_value',
                    'vAlign' => 'middle',
                    'filter' => false,
                ],

                [
                    'attribute' => 'new_value',
                    'vAlign' => 'middle',
                    'filter' => false,
                ],
                [
                    'attribute' => 'type',
                    'vAlign' => 'middle',
                    'filter' => false,
                    'value'=> function($model, $key, $index, $widget) {
                        switch ($model->type) {
                            case 0:
                                $model->type = 'create';
                                break;
                            case 1:
                                $model->type = 'edit';
                                break;
                            case 2:
                                $model->type = 'delete';
                                break;
                        }
                        return $model->type;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => [''=>'all', 0=>'create', 1=>'edit', 2=>'delete'],
                    'filterWidgetOptions' => [
                        'hideSearch' => true,
                        'pluginOptions' => ['allowClear' => false],
                    ],
                    'filterInputOptions' => ['placeholder' => '', 'multiple' => false], // allows multiple authors to be chosen
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'user_id',
                    'vAlign' => 'middle',
                    'filter' => false,
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->user->name;
                    },
                ],
            ]
            ?>
            <?= GridView::widget([
                'id' => 'history',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'showPageSummary' => false,
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => true,       
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],

                'toolbar' => false,
                'bordered' => true,
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => 'History of ID: '.$id,
                  
                    'before' => false,
                    'after' => false,
                ],
             'persistResize' => true,


            ]);
            ?>


        </div>
    </div>
</div>