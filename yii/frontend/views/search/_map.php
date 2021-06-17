<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin="" />


<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.0/leaflet.markercluster.js"></script>

<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

<div class="row">
    <div class="col-lg-9">
        <div id="map"></div>
    </div>
    <div class="col-lg-4">
        <?php $form = ActiveForm::begin([

            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <?php if (Yii::$app->controller->action->id == 'map-parasite') : ?>

            <?= $form->field($searchModel, 'parasite') ?>

            <?= $form->field($searchModel, 'host') ?>

            <?= $form->field($searchModel, 'place') ?>

            <?= $form->field($searchModel, 'province') ?>

            <?= $form->field($searchModel, 'country') ?>

            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Reset', ['search/map-parasite'], ['class' => 'btn btn-default']) ?>
            </div>
        <?php else : ?>
            <?= $form->field($searchModel, 'sciName0.scientificName') ?>
            <?= $form->field($searchModel, 'placeName0.localityName') ?>
            <?= $form->field($searchModel, 'placeName0.province') ?>
            <?= $form->field($searchModel, 'placeName0.country') ?>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Reset', ['search/map-host'], ['class' => 'btn btn-default']) ?>
            </div>
        <?php endif ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>


<script type="text/javascript">
    var geoJsonData = {

        "type": "FeatureCollection",
        "features": [
            <?= $coordinates ?>
        ]
    };
</script>

<script type="text/javascript">
    var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }),
        latlng = new L.LatLng(50.5, 30.51);

    var map = new L.Map('map', {
        center: latlng,
        zoom: 2,
        layers: [tiles],
        fullscreenControl: {
            pseudoFullscreen: false
        }
    });

    var markers = L.markerClusterGroup();

    var geoJsonLayer = L.geoJson(geoJsonData, {
        onEachFeature: function(feature, layer) {
            layer.bindPopup(feature.properties.address);
        }
    });
    markers.addLayer(geoJsonLayer);

    map.addLayer(markers);
    // map.fitBounds(markers.getBounds());
</script>