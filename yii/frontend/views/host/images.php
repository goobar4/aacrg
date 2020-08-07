<?php
use yii\helpers\Html;
use yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;

$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Host', 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = 'Images';



?>


<div class=''>
    <?php
    
    foreach ($image as $i) {
        $button = Html::a('', Url::to(['host/delete-image', 'id'=>$i->id]), $options = [
            'class'=>'glyphicon glyphicon-trash btn-default',' data-toggle'=>'tooltip', 'title'=>'Delete'
        ]);
        $rout = Url::base(true).'/uploads/images/'.$i['name'];
        echo '<div class="gallery img-thumbnail"> <div class="img">';
        
    echo EasyThumbnailImage::thumbnailImg(
        $rout,
        320,
        180,
        EasyThumbnailImage::THUMBNAIL_OUTBOUND,
        ['alt' => '']);
        echo   '</div><div class="butt">'.$button.'<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Uploaded by '.$i->user->surname.'</span></div></div>';
    }


    $this->registerCSS('
.gallery {
    display: inline-block;
    padding: 10px;
    margin: 10px;
}
.butt{
    display: block;
  
    margin-top: 5px;

}
.img{
    width: 320px;
    height: 180px;
    z-index: -100;

}


');
    $this->registerJs('
$(document).ready(function(){
    $(\'[data-toggle=\"tooltip\"]\').tooltip();
  });


')



    ?>
</div>
<!-- <img src="'. $rout .'" class="img-thumnail" width="320" height="180"> -->