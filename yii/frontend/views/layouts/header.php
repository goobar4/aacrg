<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header ">

    <?= Html::a('<span class="logo-mini"></span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top skin-green" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        


        <div class="navbar-custom-menu">



            <ul class="nav navbar-nav">
       
           
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu button">
                <?php if (Yii::$app->user->isGuest) {
                                            echo Html::a('Login', Url::to(['/site/login']), ['data-method' => 'POST']);
                                        } else {
                                            $user =Yii::$app->user->identity->username;
                                            echo Html::a('', Url::to(['/site/logout']), ['data-method' => 'POST', 'class' => 'glyphicon glyphicon-log-out']);
                                            
                                        } ?>
                    <ul class="dropdown-menu">
                        <!-- User image 
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                Alexander Pierce - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>-->
                        <!-- Menu Body 
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>-->
                        <!-- Menu Footer
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">-->
                                <?= '';/*Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) */?>
                            <!--</div>
                        </li>
                    </ul>
                </li>-->

                <!-- User Account: style can be found in dropdown.less
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
