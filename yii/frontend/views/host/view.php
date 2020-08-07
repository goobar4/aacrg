<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;
use metalguardian\fotorama\Fotorama;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Host */

$this->title = $model->occurrenceID;
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//set routs for Select2
$url_place = \yii\helpers\Url::to(['place-list']);
$url_taxon = \yii\helpers\Url::to(['taxon-list']);

//set entry of buttons

$history = Html::a('   ', Url::to(['host/history', 'id' => $model->occurrenceID, 'table'=>'host']), $options = [
    'class' => 'glyphicon glyphicon-list-alt kv-action-btn', 'data-toggle' => 'tooltip', 'title' => 'History'
]);
$upload_image = Html::a('   ', Url::to(['site/upload-image', 'id' => $model->occurrenceID]), $options = [
    'class' => 'glyphicon glyphicon-upload kv-action-btn', 'data-toggle' => 'tooltip', 'title' => 'Upload image'
]);
$images ? $image_button = '<a id="myBtn"><span class="glyphicon glyphicon-picture kv-action-btn"></span></a>' : $image_button = null;
$add_container = Html::a('', Url::to(['container/create', 'id' => $model->occurrenceID]), $option = [
    'class' => 'glyphicon glyphicon-plus kv-action-btn', 'data-toggle' => 'tooltip', 'title' => 'Add new'
]);
$restore = Html::a('Restore', Url::to(['host/restore', 'id' => $model->occurrenceID]));
$delete =Html::a('Permanent removal', ['delete', 'id' => $model->occurrenceID], [
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
]);
$manage_image = Html::a('Image', Url::to(['host/manage-image', 'id'=>$model->occurrenceID]), $options = [
    'class' => 'glyphicon glyphicon-picture ', 'data-toggle' => 'tooltip', 'title' => 'Manage image'
]);

//set items for Fotorama



foreach ($images as $image) {
    // global $items;
    $items[]['img'] = Url::base(true).'/uploads/images/' . $image->name;
}


?>


<div class="host-view">
<?php If($model->isDeleted==1){ ?>
<div class="alert alert-danger">
  <strong>Deleted!</strong> This record is deleted. Actions: <?= $restore ?> or <?= $delete ?>.
</div>
<?php } ?>

    <div class="row">

        <div class="col-lg-7">

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
                    'heading' => 'Host # ' . $model->occurrenceID,
                    'type' => DetailView::TYPE_INFO,
                    'footer' =>
                    '<div class="text-left text-muted">' . $history . '  ' . $upload_image . '  ' . $image_button . '</div>'
                ],
                'deleteOptions' => [ // your ajax delete parameters
                    'params' => ['id' => 1, 'kvdelete' => true],
                ],
                'container' => ['id' => 'host-view'],
                'formOptions' => ['action' => Url::current()],
                'attributes' => [
                    [
                        'columns' => [
                            [
                                'attribute' => 'sciName',
                                'format' => 'raw',
                                'value' => '<i>' . isset($model->sciName0->scientificName) ? $model->sciName0->scientificName:null.'</i>',
                                'type' => DetailView::INPUT_SELECT2,
                                'widgetOptions' => [
                                    'initValueText' => isset($model->sciName0->scientificName) ? $model->sciName0->scientificName:null,
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
                        ],
                    ],

                    [
                        'columns' => [
                            [
                                'attribute' => 'sex',
                                'value' => isset($model->sexValue->value) ? $model->sexValue->value : null,
                                'type' => DetailView::INPUT_SELECT2,
                                'widgetOptions' => [
                                    'data' => $lists['sex'],
                                    'options' => ['placeholder' => 'Select ...'],
                                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                                ],

                            ],
                            [
                                'attribute' => 'age',
                                'value' => isset($model->ageValue->value) ? $model->ageValue->value : null,
                                'type' => DetailView::INPUT_SELECT2,
                                'widgetOptions' => [
                                    'data' => $lists['age'],
                                    'options' => ['placeholder' => 'Select ...'],
                                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                                ],

                            ],
                        ],
                    ],
                    [
                        'attribute' => 'natureOfRecord',
                        'value' => isset ($model->natureValue->value) ? $model->natureValue->value : null,
                        'type' => DetailView::INPUT_SELECT2,
                                'widgetOptions' => [
                                    'data' => $lists['natureOfRecord'],
                                    'options' => ['placeholder' => 'Select ...'],
                                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                                ],

                    ],
                    [
                        'attribute' => 'placeName',
                        'format' => 'raw',
                        'value' => isset ($model->placeName0->localityName) ? $model->placeName0->localityName : null,
                        'type' => DetailView::INPUT_SELECT2,
                        'widgetOptions' => [
                            'initValueText' => isset ($model->placeName0->localityName) ? $model->placeName0->localityName : null,
                            'options' => ['placeholder' => '...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $url_place,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(placeName) { return placeName.text; }'),
                                'templateSelection' => new JsExpression('function (placeName) { return placeName.text; }'),

                            ],
                        ],
                    ],
                    [
                        'attribute' => 'occurenceDate',
                        'type'=>DetailView::INPUT_DATE,
                     'widgetOptions' => [
                    'pluginOptions'=>[
                    'autoclose' => true,
                        'format' => 'yyyy-mm-dd']
                     ],

                    ],
                    [
                        'attribute' => 'isEmpty',
                        'format' => 'raw',
                        'type' => DetailView::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Yes',
                                'offText' => 'No',
                            ]
                        ],
                        'value' => $model->isEmpty ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>',
                    ],
                    [
                        'attribute' => 'sAIAB_Catalog_Number',
                        'type' => DetailView::INPUT_TEXT,

                    ],
                    [
                        'attribute' => 'idConfidence',
                        'type' => DetailView::INPUT_TEXT,

                    ],
                    [
                        'attribute' => 'comments',
                        'type' => DetailView::INPUT_TEXTAREA,

                    ],                   
                    [
                        'attribute' => 'determiner',
                        'value' => isset ($model->determiner0->surname) ? $model->determiner0->surname : null,
                        'type' => DetailView::INPUT_SELECT2,
                                'widgetOptions' => [
                                    'data' => $lists['determiner'],
                                    'options' => ['placeholder' => 'Select ...'],
                                    'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                                ],

                    ],
                ]
            ]);
            //
            ?>
        </div>

        <div class="col-lg-4">
            
            <!-- if model has empty status do not show table for child-->
            <?php if ($model->isEmpty == 0) { ?>

                <div class='kv-view-mode'>
                    <table class="kv-view-mode table table-bordered table-hover" id="111">
                        <thead class='panel panel-info'>
                            <tr class='panel-heading'>
                                <th class='panel-title'>Container<?= $add_container ?></th>
                                <th class='panel-title'>Type</th>
                                <th class='panel-title'>Species</th>
                            </tr>
                        </thead>
                        <tbody class='kv-detail-view table-responsive table table-hover table-bordered detail-view'>
                            <?php foreach ($sql as $d) { ?>

                                <tr>
                                    <td><a href="<?= Url::to(['container/view', 'id' => $d['containerId']]) ?>"><?= $d['containerId'] ?></a></td>
                                    <td>
                                        <?=  $d['value'] ?>
                                    </td>
                                    <td>
                                        <? if($d['prepType']!=='21'){
                                        echo $d['scientificName'] ?'<i>'.$d['scientificName'] . '</i> ('./* $d['sex'] .*/  $d['individualCount'] . ')' : null; }
                                        ?>
                                    </td>

                                </tr>

                        <?php }
                        } ?>

                        <tbody>
                    </table>
                </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="myModal" role="gallery">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3><?=$manage_image?></h3>
            </div>
            <div class="modal-body" id='image' style="padding:40px 50px;">
                <div>
                    <?php
                    //if record has images set modal
                    if ($images) {


                        echo Fotorama::widget(
                            [
                                'items' => $items,
                                'options' => [
                                    'nav' => 'dots',
                                    'allowfullscreen' => 'true',                                    
                                ],
                            ]
                        );
                    }



                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->registerJs("
  
$(document).ready(function(){
   
    //show modal for new location and load form in this modal
    $('#myBtn').click(function(){
      $('#myModal').modal();
      $('#myModal').find('#main').load('/index.php?r=locality%2Frenderajax');
      $('#host-sciname')[0].append('<option value=>dwe511111</option>');
    });
  });

  ");
