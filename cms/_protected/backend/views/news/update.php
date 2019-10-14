<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = 'Cập nhật bài viết';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách bài viết', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<article class="page-update">

    <div class="container-fluid">
        <h2><?= Html::encode($this->title) ?> <?= $this->render('_popup') ?></h2>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'tags' => $tags,
        'tagSuggestions' => $tagSuggestions,
        'pictures' => $pictures,
    ]) ?>
</article>
