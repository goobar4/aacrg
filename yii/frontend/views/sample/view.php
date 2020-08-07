<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Sample */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => $back, 'url' => Url::to(['host/view', 'id' => $back])];
$this->params['breadcrumbs'][] = ['label' => $model->parId, 'url' => Url::to(['container/view', 'id' => $model->parId])];
$this->params['breadcrumbs'][] = $model->scienName0->scientificName;
\yii\web\YiiAsset::register($this);


$url_taxon = \yii\helpers\Url::to(['taxon-list']);


$restore = Html::a('Restore', Url::to(['restore', 'id' => $model->id]));
$delete = Html::a('Permanent removal', ['delete', 'id' => $model->id], [
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
]);
$history = Html::a('   ', Url::to(['host/history', 'id' => $model->id, 'table'=>'sample']), $options = [
    'class' => 'glyphicon glyphicon-list-alt kv-action-btn', 'data-toggle' => 'tooltip', 'title' => 'History'
]);
?>
<div class="sample-view">
<?php if ($model->isDeleted == 1) { ?>
        <div class="alert alert-danger">
            <strong>Deleted!</strong> This record is deleted. Actions: <?= $restore ?> or <?= $delete ?>.
        </div>
    <?php } ?>
    
    <div class="row">

<div class="col-lg-6">
    <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'bordered' => true,
                'striped' => false,
                'hideIfEmpty' => true,
                'hideAlerts' => true,
                'mode' => DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => isset ($model->scienName0->scientificName) ? $model->scienName0->scientificName : null,
                    'type' => DetailView::TYPE_INFO,
                    'footer' => 
                    '<div class="text-left text-muted">' . $history .'</div>'
                ],
                'deleteOptions' => [ // your ajax delete parameters
                    'params' => ['id' => 1, 'kvdelete' => true],
                ],
                'container' => ['id' => 'host-view'],
                'formOptions' => ['action' => Url::current()],
                'attributes' => [

                    [
                    'attribute' => 'scienName',
                    'value' =>  isset ($model->scienName0->scientificName) ? $model->scienName0->scientificName : null,
                    'type' => DetailView::INPUT_SELECT2,
                    'widgetOptions' => [
                        'initValueText' =>  isset ($model->scienName0->scientificName) ? $model->scienName0->scientificName : null,
                        'options' => ['placeholder' => '...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => $url_taxon,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(sciName) { return sciName.text; }'),
                            'templateSelection' => new JsExpression('function (sciName) { return sciName.text; }'),
                        ],
                    ],
                ],                 
                    
                    [
                        'attribute' => 'individualCount',
                        'value' => isset ($model->individualCount) ? $model->individualCount : null,                        
                    ],

                    [
                        'attribute' => 'site',
                        'value' => isset ($model->site0->value) ? $model->site0->value: null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['site'],
                            'hideSearch' => true,
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                        ],

                    ],

                    [
                        'attribute' => 'basisOfRecord',
                        'value' => isset ($model->basisOfRecord0->value) ? $model->basisOfRecord0->value : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['basisOfRecord'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],                        
                    ],
                ],

                    [
                        'attribute' => 'typeStatus',
                        'value' => isset ($model->typeStatus0->value) ? $model->typeStatus0->value : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['typeStatus'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],                          
                    ],
                ],

                    [
                        'attribute' => 'remarks',
                        'value' => $model->remarks,  
                        'type' => DetailView::INPUT_TEXTAREA,                      
                    ],

                    [
                        'attribute' => 'identifiedBy',
                        'value' => isset ($model->identifiedBy0->surname) ? $model->identifiedBy0->surname : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'data' => $lists['identifiedBy'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear' => true, 'width' => '100%'],                          
                    ],
                ],

                    [
                        'attribute' => 'qualifier',
                        'value' => $model->qualifier,                        
                    ],

                    [
                        'attribute' => 'confidence',
                        'value' => $model->confidence,                        
                    ],


                ],
            ]);
                ?>


</div></div>


</div>
