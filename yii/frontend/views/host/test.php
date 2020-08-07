
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hosts';


If (isset($contoller)){
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Trash'];}
else{
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="host-index">

    <p>
        <?= Html::a('Create Host', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">

<div class="col-sm-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-responsive table-condensed table-hover'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'occurrenceID',
            'scientificName',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div></div>
</div>
