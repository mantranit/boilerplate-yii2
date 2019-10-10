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

            <nav class="main-nav">
                <?php
                echo Nav::widget([
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
                                    'label' => 'Quản lý User',
                                    'url' => ['user/index'],
                                    'visible' => isset($role['admin'])
                                ],
                                [
                                    'label' => 'Quản lý Tags',
                                    'url' => ['tag/index'],
                                    'visible' => isset($role['admin'])
                                ]
                            ]
                        ],
                    ],
                ]);
                ?>
            </nav>
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

        // $(document).foundation();
    ");
    ?>
</body>
</html>
<?php $this->endPage() ?>
