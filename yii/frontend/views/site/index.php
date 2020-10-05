<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="site-index">
  <div class="jumbotron">
    <h1>Data base for parasites</h1>

   <!-- <p class="lead">Data base for parasites</p>-->

  </div>

  <div class="row">

    <div class="col-lg-3">
    </div>
    <div class="col-lg-3">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?= $count['host'] ?></h3>

          <p>Host records</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <?= Html::a(
          'To hosts <i class="fa fa-arrow-circle-right"></i>',
          Url::to(['host/index']),
          $options = ['class' => 'small-box-footer']
        )
        ?>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?= $count['container'] ?></h3>

          <p>Container records</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <?= Html::a(
          'To containers <i class="fa fa-arrow-circle-right"></i>',
          Url::to(['container/index']),
          $options = ['class' => 'small-box-footer']
        )
        ?>
      </div>
    </div>

  </div>