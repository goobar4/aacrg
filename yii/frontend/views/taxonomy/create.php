<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Taxonomy */

$this->title = 'Create Taxonomy';
$this->params['breadcrumbs'][] = ['label' => 'Taxonomies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-create">

    <button type="button" class="btn btn-info btn-xs" data-toggle="collapse" data-target="#demo">Tip</button>
	<div id="demo" class="collapse">
    Use parID = root to add new phylum.
	</div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
