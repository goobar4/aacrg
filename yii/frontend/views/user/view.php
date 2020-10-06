<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User: ' . $model->surname;
Yii::$app->user->can('canAdmin') ? $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']] : null;
$this->params['breadcrumbs'][] = $model->surname;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <span>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сhange password', ['changepassword', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>


        <?php if (Yii::$app->user->can('canAdmin')) : ?>

            <div class="dropdown" style="display: inline-block">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Change Role
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">

                    <li><?= Html::a('admin', ['changerole', 'id' => $model->id, 'name' => 'admin']) ?></li>
                    <li><?= Html::a('user', ['changerole', 'id' => $model->id, 'name' => 'user']) ?></li>
                    <li><?= Html::a('student', ['changerole', 'id' => $model->id, 'name' => 'student']) ?></li>
                    <li><?= Html::a('guest', ['changerole', 'id' => $model->id, 'name' => 'guest']) ?></li>
                    <li><?= Html::a('nonactive', ['changerole', 'id' => $model->id, 'name' => 'nonactive']) ?></li>
                </ul>
            </div>
            <?= Html::a('Add permission', Url::to(['user/create-permission', 'id' => $model->id]), ['class' => 'btn btn-primary']); ?>

        <?php endif; ?>

        <?php if ($model->id !== Yii::$app->user->identity->id) {
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        } ?>
    </span>
    <h3>&nbsp</h3>
    <div class="row">
        <div class="col-sm-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'username',
                    'name',
                    'surname',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    [
                        'attribute' => 'role.item_name',
                        'label' => 'Status',
                    ],
                    //'email:email',
                    //'status',
                    //'created_at',
                    //'updated_at',
                    //'verification_token',
                ],
            ]) ?>

        </div>
        <div class="col-sm-4">
            <?php if (Yii::$app->user->can('canAdmin')) : ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => false,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'taxon.scientificName',
                            'label' => 'Permissions'
                        ],
                        //'user.surname',

                        [

                            'class' => \yii\grid\ActionColumn::class,

                            'template' => ' {update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {

                                    $url = Url::to(['user/access-update', 'id' => $model->id,]);

                                    return Html::a('',  $url, ['class' => 'glyphicon glyphicon-pencil']);
                                },
                                'delete' => function ($url, $model, $key) {

                                    $url = Url::to(['user/delete-permission', 'id' => $model->id, 'user' => $model->user_id]);

                                    return Html::a('',  $url, ['class' => 'glyphicon glyphicon-trash']);
                                }
                            ]
                        ]
                    ],
                ]); ?>
            <?php endif; ?>
        </div>

    </div>
</div>