<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
// use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yiister\gentelella\assets\Asset;
use yiister\gentelella\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
Asset::register($this);

$role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
if(!isset($role['admin'])) {
    Yii::$app->user->logout();
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap&subset=latin-ext,vietnamese" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title">
                    <a href="/" class="site_title"><i class="fa fa-paw"></i> &nbsp; <span>DUY TAN</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="<?= Yii::$app->view->theme->baseUrl ?>/images/user.png" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>ADMIN</span>
                        <h2><?= Yii::$app->user->identity->full_name ? Yii::$app->user->identity->full_name : Yii::$app->user->identity->username ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <?php
                            echo Menu::widget([
                                'items' => [
                                    [
                                        'label' => 'Tổng quan',
                                        'url' => ['site/index'],
                                        'icon' => 'home',
                                        'visible' => isset($role['admin'])
                                    ],
                                    [
                                        'label' => 'Quản lý sản phẩm',
                                        'url' => '#',
                                        'icon' => 'shopping-bag',
                                        'visible' => isset($role['admin']),
                                        'items' => [
                                            [
                                                'label' => 'Danh sách sản phẩm',
                                                'url' => ['product/index'],
                                                'visible' => isset($role['admin']),
                                            ],
                                            [
                                                'label' => 'Danh sách danh mục',
                                                'url' => ['category/index'],
                                                'visible' => isset($role['admin'])
                                            ]
                                        ]
                                    ],
                                    [
                                        'label' => 'Danh sách bài viết',
                                        'url' => ['news/index'],
                                        'icon' => 'th-list',
                                        'visible' => isset($role['admin'])
                                    ],
                                    [
                                        'label' => 'Quản lý Slide',
                                        'url' => ['slider/index'],
                                        'icon' => 'th-large',
                                        'visible' => isset($role['admin'])
                                    ],
                                    [
                                        'label' => 'Quản lý Banner',
                                        'url' => ['banner/index'],
                                        'icon' => 'film',
                                        'visible' => isset($role['admin'])
                                    ],
                                    [
                                        'label' => 'Danh sách trang',
                                        'url' => ['page/index'],
                                        'icon' => 'file',
                                        'visible' => isset($role['admin'])
                                    ],
                                    [
                                        'label' => 'Cấu hình',
                                        'url' => '#',
                                        'icon' => 'gear',
                                        'visible' => isset($role['admin']),
                                        'items' => [
                                            [
                                                'label' => 'Popup chào mừng',
                                                'url' => ['config/splash-screen'],
                                                'visible' => isset($role['admin'])
                                            ],
                                            [
                                                'label' => 'Sắp xếp SP nổi bật',
                                                'url' => ['config/featured'],
                                                'visible' => isset($role['admin'])
                                            ]
                                        ]
                                    ],
                                    [
                                        'label' => 'Admin',
                                        'url' => '#',
                                        'icon' => 'users',
                                        'visible' => isset($role['admin']),
                                        'items' => [
                                            [
                                                'label' => 'QL User',
                                                'url' => ['user/index'],
                                                'visible' => isset($role['admin'])
                                            ],
                                            [
                                                'label' => 'QL Tags',
                                                'url' => ['tag/index'],
                                                'visible' => isset($role['admin'])
                                            ]
                                        ]
                                    ],
                                ],
                            ]);
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span>', ['/site/logout'], [
                        'data-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'top',
                        'title'=>'Logout',
                        ]) ?>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?= Yii::$app->view->theme->baseUrl ?>/images/user.png" alt=""><?= Yii::$app->user->identity->full_name ? Yii::$app->user->identity->full_name : Yii::$app->user->identity->username ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <!-- <li><a href="javascript:void(0);">Profile</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Help</a>
                                </li> -->
                                <li>
                                    <?= Html::a('<i class="fa fa-sign-out pull-right"></i> Log Out', ['/site/logout'], [
                                        'data-method'=>'post',
                                        ]) ?>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                2015 &copy; <?= Yii::$app->name ?>. Powered by <?= Html::a('Man Tran', 'http://www.mantran.net', ['rel'=>"nofollow", 'target' => '_blank']) ?>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage() ?>
