<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Thêm danh mục sản phẩm';
$this->params['breadcrumbs'][] = ['label' => 'Danh sach danh mục', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="category-create">
    <div class="container-fluid">
        <h2>
            <?= Html::encode($this->title) ?>
        </h2>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</article>
