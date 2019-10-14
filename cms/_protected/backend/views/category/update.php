<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Cập nhật danh mục';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách danh mục', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<article class="category-update">

    <div class="container-fluid">
        <h2>
            <?= Html::encode($this->title) ?>
            <div class="actions">
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-lg btn-link']) ?>
            </div>
        </h2>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</article>
