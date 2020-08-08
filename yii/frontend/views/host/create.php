<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Host */

$this->title = 'Create Host';
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="host-create">


</div>

<button type="button" class="btn btn-default btn-lg" id="myBtn"><span class="glyphicon glyphicon-map-marker"></span></button>
<?= $this->render('_form', [
  'model' => $model,
  'lists' => $lists,
  
]) ?>

</div>



<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="glyphicon glyphicon-map-marker"></span> Locality</h4>
      </div>
      <div class="modal-body" id='main' style="padding:40px 50px;">
        <div>
          
          <div class="loader">
            <!--<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!--Progress Modal-->
<div class="modal fade" id="progress" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="glyphicon glyphicon-map-marker"></span> Locality</h4>
      </div>
      <div class="modal-body" style="padding:40px 50px;">
      <div class="loader">
          

          <!--<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">-->
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
      $('#myModal').find('#main').load('".Url::toRoute(['locality/renderajax'], $schema = true)."');
      //show loader
      $('#host-sciname')[0].append('<option value=>dwe511111</option>');
    });
  });

  ");
  $this->registerCss("
  .loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3498db;
    width: 60px;
    height: 60px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
  }
  
  /* Safari */
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  
    ");
?>