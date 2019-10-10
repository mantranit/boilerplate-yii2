<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yiister\gentelella\assets\Asset;

/* @var $this \yii\web\View */
/* @var $content string */
Asset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap&subset=latin-ext,vietnamese" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div class="site-wrapper">
    <?php $this->beginBody() ?>
    <div class="wrapper row">
        <div class="large-12 columns content-bg">
            <div class="row">
                <main class="large-10 medium-12 small-12 columns container" role="main">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => ['class' => 'breadcrumbs']
                    ]) ?>
                    <?= $content ?>
                </main>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
