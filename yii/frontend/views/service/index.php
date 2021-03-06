<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lists';
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->getUser()->identity->role;
   
if (Yii::$app->user->can('canAdmin') || $user->item_name == 'user'){
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
<div class="service-index">

    <p>
    <?php if (Yii::$app->user->can('canAdmin') || $user->item_name == 'user'){
         echo Html::a('Create', ['create'], ['class' => 'btn btn-success']);} ?>
        <?= Html::a('Reset', ['index', 'reset' => 1], ['class' => 'btn btn-default']) ?>
    </p>
    <div class="row">

        <div class="col-sm-6">

            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered table-responsive table-condensed table-hover'
                ],
                'columns' => [
                    $actionColumn,
                    'id',
                    'value',
                    'target',
                    '_table',

                ],

            ]) ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>