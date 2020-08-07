<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Search';


$this->params['breadcrumbs'][] = $this->title;

?>
 
<div class="host-index">
    <div class="row">


        <div class="col-lg-3">

            <?= $this->render('_search', ['model' => $searchModel, 'flag'=>1]); ?>
        </div>

        <div class="col-lg-9">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered table-responsive table-condensed table-hover'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'containerId',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model['prepType'] !== 'nosample') {
                                return Html::a($model['containerId'], Url::to(['container/view', 'id' => $model['containerId']]));
                            } else {
                                return '';
                            }
                        },
                    ],

                    'prepType',

                    [
                        'attribute' => 'parasite',
                        'format' => 'raw',
                        'value' => function ($model) {

                            if ($model['parasite'] === null or $model['parasite'] == 'nohelminth') {
                                return '';
                            } else {
                                return $model['parasite'];
                            }
                        },
                    ],

                    [
                        'attribute' => 'hostN',
                        'format' => 'raw',
                        'value' => function ($model) {

                            return Html::a($model['hostN'], Url::to(['host/view', 'id' => $model['hostN']]));
                        },
                    ],
                    'host',
                    'place',
                    'date',


                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
<?php $this->registerJs("
//set cursor in Id input
$('#host-occurrenceid').focus();
//toggle additional fields
$('#tbutton').click(function(){
  var tbutton =$('#tbutton');
  var text= tbutton.html();
  text=='More fields' ? tbutton.html('Less fields') : tbutton.html('More fields');
});

");
?>