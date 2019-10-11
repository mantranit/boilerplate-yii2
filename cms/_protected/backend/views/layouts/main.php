<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

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
<body>
<?php $this->beginBody() ?>
    <div class="site-wrapper">
        <header class="site-header">
            <?php
                NavBar::begin(['brandLabel' => '<i class="fa fa-paw"></i> &nbsp; <span>DUY TAN</span>']);
                echo Nav::widget([
                    'items' => [
                        [
                            'label' => Yii::$app->user->identity->username,
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Đăng xuất',
                                    'url' => ['/site/logout'],
                                    'linkOptions' => ['data-method'=>'post'],
                                ],
                            ]
                        ],
                    ],
                    'options' => ['class' => 'navbar-nav ml-auto mr-2'],
                ]);
                NavBar::end();
            ?>
        </header>
        <aside class="floating-menu">
            <div class="profile">
                <img src="" alt="" />
            </div>
            <nav class="main-nav">
                <?php
                echo Nav::widget([
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'label' => 'GENERAL',
                            'url' => '#',
                            'options' => ['disabled' => 'disabled'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-home"></i> Tổng quan',
                            'url' => ['site/index'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-archive"></i> Quản lý sản phẩm',
                            'url' => '#',
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
                            'label' => '<i class="fa fa-th-list"></i> Danh sách bài viết',
                            'url' => ['news/index'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-th-large"></i> Quản lý Slide',
                            'url' => ['slider/index'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-film"></i> Quản lý Banner',
                            'url' => ['banner/index'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-file"></i> Danh sách trang',
                            'url' => ['page/index'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-gear"></i> Cấu hình',
                            'url' => '#',
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
                            'label' => 'ADMIN',
                            'url' => '#',
                            'options' => ['disabled' => 'disabled'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-user"></i> Quản lý User',
                            'url' => ['user/index'],
                            'visible' => isset($role['admin'])
                        ],
                        [
                            'label' => '<i class="fa fa-tag"></i> Quản lý Tags',
                            'url' => ['tag/index'],
                            'visible' => isset($role['admin'])
                        ]
                    ],
                ]);
                ?>
            </nav>
            <div class="system-ctas">
                <?php 
                echo Html::beginForm(['/site/logout'], 'post');
                echo Html::submitButton(
                    '<i class="fa fa-power-off" aria-hidden="true"></i>',
                    ['class' => 'btn btn-link logout']
                );
                echo Html::endForm();
                ?>
            </div>
        </aside>
        <div class="wrapper">
            <main class="large-10 medium-12 small-12 columns container" role="main">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'breadcrumbs']
                ]) ?>
                <?= $content ?>
            </main>
        </div>
    </div>
<?php $this->endBody() ?>
<?php
    $this->registerJs("
//        var goLockScreen = false;
//        var stop = false;
//        var autoLockTimer;
//        window.onload = resetTimer;
//        window.onmousemove = resetTimer;
//        window.onmousedown = resetTimer; // catches touchscreen presses
//        window.onclick = resetTimer;     // catches touchpad clicks
//        window.onscroll = resetTimer;    // catches scrolling with arrow keys
//        window.onkeypress = resetTimer;
//
//        function lockScreen() {
//            stop = true;
//            window.location.href = '" . Url::toRoute(['/site/lock-screen']) . "?previous='+encodeURIComponent(window.location.href);
//        }
//
//        function lockIdentity(){
//            goLockScreen = true;
//        }
//
//        function resetTimer() {
//            if(stop==true){
//
//            }
//            else if (goLockScreen) {
//                lockScreen();
//            }
//            else{
//                clearTimeout(autoLockTimer);
//                autoLockTimer = setTimeout(lockIdentity, " . (Yii::$app->session->timeout * 1000) . ");  // time is in milliseconds
//            }
//
//        }

        const childActive = $('.floating-menu .dropdown-item.active');
        childActive.parent().addClass('show').parent().addClass('show');
    ");
    ?>
</body>
</html>
<?php $this->endPage() ?>
