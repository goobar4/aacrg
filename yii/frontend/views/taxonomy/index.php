<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxonomy';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-index">

    <p>
        <?php
        
        $user = Yii::$app->getUser()->identity->role;
        
        if (Yii::$app->user->can('canAdmin') || $user->item_name == 'user'){
             echo Html::a('Create', ['create'], ['class' => 'btn btn-success']);} ?>
        <?= Html::a('Reset', ['index', 'reset'=>1], ['class' => 'btn btn-default']) ?>
        <?php
        if(Yii::$app->user->can('canAdmin')){
            echo Html::a('Re-index', ['re-index'], [
                'class' => 'btn btn-default',
                'data' => [
                    'confirm' => 'It may take a few minutes?',
                    'method' => 'get',
                ],
            ]);           
        }
        ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-responsive table-hover'
        ],
        'columns' => [
           
            [
                'attribute' => 'species',
                'format' => 'raw',
                'value' => function($model){
                   
                    return Html::a($model['species'], Url::to(['taxonomy/update', 'id'=>$model['sID']]));
                   
                },
            ],
            [
                'attribute' => 'genus',
                'format' => 'raw',
                'value' => function($model){
                   
                    return Html::a($model['genus'], Url::to(['taxonomy/update', 'id'=>$model['gID']]));
                   
                },
            ],
            [
                'attribute' => 'family',
                'format' => 'raw',
                'value' => function($model){
                   
                    return Html::a($model['family'], Url::to(['taxonomy/update', 'id'=>$model['fID']]));
                   
                },
            ],
            [
                'attribute' => 'order',
                'format' => 'raw',
                'value' => function($model){
                   
                    return Html::a($model['order'], Url::to(['taxonomy/update', 'id'=>$model['oID']]));
                   
                },
            ],
            [
                'attribute' => 'class',
                'format' => 'raw',
                'value' => function($model){
                   
                    return Html::a($model['class'], Url::to(['taxonomy/update', 'id'=>$model['cID']]));
                   
                },
            ],
            [
                'attribute' => 'phylum',
                'format' => 'raw',
                'value' => function($model){
                   
                    return Html::a($model['phylum'], Url::to(['taxonomy/update', 'id'=>$model['pID']]));
                   
                },
            ],
                  
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
