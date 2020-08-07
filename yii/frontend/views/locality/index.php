<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LocalitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Localities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locality-index">

    
    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Reset', ['index', 'reset'=>1], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="row">

<div class="col-sm-6">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
       
            'localityName',
            [
                'attribute'=>'province0.value',
                'label'=>'Province',
                
            ],
            [
                'attribute'=>'country0.value',
                'label'=>'Country',
                
            ],                     
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
    </div>

</div>
