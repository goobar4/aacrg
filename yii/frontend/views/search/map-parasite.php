<?php
$this->title = Yii::t('app', 'Map (parasite)');

use yii\helpers\Url;

$coordinates = '';


foreach ($dataProvider->models as $model) {
    $link_content = $model['parasite'] . ' (' . $model['containerId'] . ')';
    $url = Url::to(['container/view', 'id' => $model['containerId']]);
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
                "coordinates": [' . $model['decimalLongitude'] . ',' . $model['decimalLatitude'] . ']
            }
        },';
}

echo $this->render('_map', ['coordinates' => $coordinates, 'searchModel'=>$searchModel]);

?>