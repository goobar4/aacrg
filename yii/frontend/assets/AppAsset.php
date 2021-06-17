<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/map/screen.css',
        'css/map/MarkerCluster.css',
        'css/map/MarkerCluster.Default.css'
    ];
    public $js = [
       
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        //'yiister\gentelella\assets\Asset',
		
    ];
}
