<?php
$this->title = Yii::t('app', 'Map (host)');

use yii\helpers\Url;

$coordinates = '';


foreach ($dataProvider->models as $model) {
 
    $link_content = $model->sciName0->scientificName . ' (' . $model->occurrenceID . ')';
    $url = Url::to(['host/view', 'id' => $model->occurrenceID]);
    $link = "<a href=$url>$link_content</a";

    $coordinates = $coordinates . '
            {
            "type": "Feature",
   
            "properties": {
                "address": "' .
        $link
        . '"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [' .  $model->placeName0->decimalLongitude . ',' . $model->placeName0->decimalLatitude . ']
            }
        },';
}

echo $this->render('_map', ['coordinates' => $coordinates, 'searchModel'=>$searchModel]);
