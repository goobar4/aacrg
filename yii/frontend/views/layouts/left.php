<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!--
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php //echo $directoryAsset 
                            ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        -->

        <!-- search form 
        <form action=<?php // Url::to(['search/index'], $schema = true)
                        ?> method="get" class="sidebar-form">
            <div class="input-group">
                <?php /*
                $url = Url::to(['search/simple']);
                echo  Select2::widget([
                    'name' => 'search',
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Search...',],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(localityName) { return localityName.text; }'),
                        'templateSelection' => new JsExpression('function (localityName) { return localityName.text; }'),
                    ],
                ]);
                */ ?>
                <span class="input-group-btn">
                    <button type='submit' action=<?php // Url::to(['search/index'], $schema = true)
                                                    ?>  id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Main navigation', 'options' => ['class' => 'header']],
                    ["label" => "Home", "url" => ['site/index'], "icon" => "home"],
                    ['label' => 'Search', 'icon' => 'search', 'url' => ['search/vial']],
                    ["label" => "My collection", "url" => ['sample/collection'], "icon" => "list"],
                    ["label" => "Users", "url" => ["user/index"], "icon" => "fas fa-address-book", 'visible' => Yii::$app->user->can('canAdmin')],
                    [
                        "label" => "Data tables",
                        "icon" => "table",
                        "url" => "#",
                        "items" => [
                            ["label" => "Hosts", "url" => ["host/index"]],
                            ["label" => "Containers", "url" => ["container/index"]],
                            ["label" => "Sample", "url" => ["sample/index"]],
                        ],
                    ],

                    [
                        "label" => "Service tables",
                        "icon" => "table",
                        "url" => "#",
                        "items" => [
                            ["label" => "Taxonomy", "url" => ["taxonomy/index"]],
                            ["label" => "Locality", "url" => ["locality/index"]],
                            ["label" => "Lists", "url" => ["service/index"]],
                            ["label" => "Storage", "url" => ["storage/index"]],
                        ],
                    ],

                    [
                        "label" => "Trash",
                        "icon" => "trash",
                        "url" => "#",
                        "items" => [
                            ["label" => "Hosts", "url" => ["host/deleted-host"]],
                            ["label" => "Container", "url" => ["container/deleted-container"]],
                            ["label" => "Sample", "url" => ["sample/deleted-sample"]],
                        ],
                    ],

                    [
                        "label" => "Map",
                        "icon" => "map",
                        "url" => "#",
                        "items" => [
                            ["label" => "Hosts", "url" => ["search/map-host"]],
                            ["label" => "Parasites", "url" => ["search/map-parasite"]],
                        ],
                    ],

                    ["label" => "Profile", "url" => ['user/view', 'id' => Yii::$app->user->id], "icon" => "user"],
                    ["label" => "Export", "url" => ['search/export'], "icon" => "fas fa-download", 'visible' => Yii::$app->user->can('canAdmin')],
                    ["label" => "Import", "url" => ['import/index'], "icon" => "fas fa-upload", 'visible' => Yii::$app->user->can('canAdmin')],
                    ["label" => "About", "url" => ['site/about'], "icon" => "question"],

                ],
            ]
        ) ?>

    </section>

</aside>