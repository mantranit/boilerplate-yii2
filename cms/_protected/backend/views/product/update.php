<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $pictures Array */
/* @var $categories string */
/* @var $tags Array */
/* @var $tagSuggestions string */
/* @var $products Array */
/* @var $productSuggestion Array */

$this->title = 'Cập nhật sản phẩm';
?>

<article class="product-update">

    <div class="container-fluid">
        <h2><?= Html::encode($this->title) ?> <?= $this->render('_popup') ?></h2>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'pictures' => $pictures,
        'categories' => $categories,
        'tags' => $tags,
        'tagSuggestions' => $tagSuggestions,
        'products' => $products,
        'productSuggestion' => $productSuggestion
    ]) ?>
</article>