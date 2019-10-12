<?php
use backend\assets\FullAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
FullAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap&subset=latin-ext,vietnamese" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="full">
    <?php $this->beginBody() ?>
    <div class="site-wrapper">
        <div class="wrapper">
            <div class="navbar">
                <a href="/" class="site_title"><i class="fa fa-paw"></i> &nbsp; <span><?= Yii::$app->name ?></span></a>
            </div>
            <div class="content">
                <?= $content ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
