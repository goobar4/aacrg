<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
     <div class="col-lg-6">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'hover' => true,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-responsive table-condensed table-hover'
        ],
        'options' => ['style' => 'font-size:14px;'],
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
              [
                'attribute' => 'username',
                'label'=>'Username',
                'format' => 'raw',
                'value' => function($model){
                  return Html::a($model->username, ['view', 'id'=>$model->id],['class'=>'btn-link']);
                },
              ],
            'name',
            'surname',
            //'auth_key',
            //'password_hash',
            [
                'attribute' => 'role.item_name',
                'label'=>'Status',
        
           
        
            ],
            //'password_reset_token',
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
           /* ['class' => \yii\grid\ActionColumn::class,

            'template' => '{info}',
            'buttons' => [

                'info' => function ($url, $model, $key) {
                    
                              
                    $icon = Html::a('Сhange password', ['changepassword', 'id' => $key], ['class' => 'btn btn-primary btn-xs']);                
                    return Html::a($icon);

                }
            ],
        
            ],
            ['class' => \yii\grid\ActionColumn::class,

            'template' => '{info}',
            'buttons' => [

                'info' => function ($url, $model, $key) {
                    
                    $a='      <a></a>        <div class="dropdown">
                    <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Change Role
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <li><a href="/index.php?r=user%2Fchangerole&amp;id='.$key.'&amp;name=admin" data-confirm="Are you sure you want to change role of this user?" data-method="post">admin</a></li>
                      <li><a href="/index.php?r=user%2Fchangerole&amp;id='.$key.'&amp;name=user" data-confirm="Are you sure you want to change role of this user?" data-method="post">user</a></li>
                      <li><a href="/index.php?r=user%2Fchangerole&amp;id='.$key.'&amp;name=guest" data-confirm="Are you sure you want to change role of this user?" data-method="post">guest</a></li>
                      <li><a href="/index.php?r=user%2Fchangerole&amp;id='.$key.'&amp;name=guest" data-confirm="Are you sure you want to change role of this user?" data-method="post">nonactive</a></li>
                    </ul>
                  </div>';        
                    $icon = $a;                
                    return Html::a($icon);

                }
            ],
        
            ],
            ['class' => \yii\grid\ActionColumn::class,

            'template' => '{info}',
            'buttons' => [

                'info' => function ($url, $model, $key) {
                    
                              
                    $icon = Html::a('Edit', ['update', 'id' => $key], ['class' => 'btn btn-primary btn-xs']);                
                    return Html::a($icon);

                }
            ],*/
        
            ],
        
    ]); ?>

    <?php Pjax::end(); ?>
        </div>
            </div>

    
</div>


