<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StorageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Storages';
$this->params['breadcrumbs'][] = $this->title;
if (Yii::$app->user->can('canAdmin')){
    $actionColumn = 
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update} {delete} '
    ];
    } else {
        $actionColumn = [
            'class' => 'yii\grid\ActionColumn',
            'template' => ''
        ];
    }
?>
<div class="storage-index">

    <p>
        <? if (Yii::$app->user->can('canAdmin')){
            echo Html::a('Create', ['create'], ['class' => 'btn btn-success']);} ?>
        <?= Html::a('Reset', ['index', 'reset'=>1], ['class' => 'btn btn-default']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [           
            $actionColumn,
            'item1',
            'item2',
            'item3',
            'item4',
            'item5',
            'item6',
            'item7',

           
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
