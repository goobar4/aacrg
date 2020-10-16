<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Export';


$this->params['breadcrumbs'][] = $this->title;

?>
<?php $gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],

    [
        'attribute' => 'hostN',
        'label' => 'Organism ID',
        'format' => 'raw'
    ],

    [
        'attribute' => 'host',
        'label' => 'Scientific name (h)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'genusH',
        'label' => 'Genus (h)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'familyH',
        'label' => 'Family (h)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'orderH',
        'label' => 'Order (h)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'classH',
        'label' => 'Class (h)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'PhylumH',
        'label' => 'Phylum (h)',
        'format' => 'raw'
    ],
    [
        'attribute' => 'sex',
        'label' => 'sex (h)',
        'format' => 'raw'
    ],
    [
        'attribute' => 'age',
        'label' => 'lifeStage (h)',
        'format' => 'raw'
    ],
        
    [
        'attribute' => 'place',
        'label' => 'locality',
        'format' => 'raw'
    ],

    [
        'attribute' => 'decimalLatitude',
        'label' => 'decimalLatitude',
        'format' => 'raw'
    ],

    [
        'attribute' => 'decimalLongitude',
        'label' => 'decimalLongitude',
        'format' => 'raw'
    ],

    [
        'attribute' => 'province',
        'label' => 'stateProvince',
        'format' => 'raw'
    ],

    [
        'attribute' => 'country',
        'label' => 'country',
        'format' => 'raw'
    ],

    [
        'attribute' => 'date',
        'label' => 'occurenceDate',
        'format' => 'raw'
    ],

    [
        'attribute' => 'containerId',
        'label' => 'container',
        'format' => 'raw'
    ],

    [
        'attribute' => 'speciesP',
        'label' => 'Scientific name (p)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'genusP',
        'label' => 'Genus (p)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'familyP',
        'label' => 'Family (p)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'orderP',
        'label' => 'Order (p)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'classP',
        'label' => 'Class (p)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'phylumP',
        'label' => 'Phylum (p)',
        'format' => 'raw'
    ],

    [
        'attribute' => 'individualCount',
        'label' => 'individualCount',
        'format' => 'raw'
    ],




]; ?>
<div class="host-index">
    <div class="row">
        <div class="col-lg-9">
        </div>
        <div class="col-lg-3" align ='right'>
            <?php echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'deleteAfterSave' => true, // this will delete the saved web file after it is streamed to browser,
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_EXCEL => false,
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">


        <div class="col-lg-3">

            <?= $this->render('_search', ['model' => $searchModel, 'flag' => 2]); ?>
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
                        'attribute' => 'hostN',
                        'label' => 'host id',
                        'format' => 'raw',
                        'value' => function ($model) {

                            return Html::a($model['hostN'], Url::to(['host/view', 'id' => $model['hostN']]));
                        },
                    ],
                    'host',

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