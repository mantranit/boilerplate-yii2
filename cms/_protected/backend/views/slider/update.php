<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = 'Cập nhật slide';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách slide', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<article class="page-update">
    <div class="container-fluid">
        <h2>
            <?= Html::encode($this->title) ?>
            <div class="actions">
                <?= $this->render('_popup') ?>
            </div>
        </h2>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'pictures' => $pictures,
    ]) ?>

</article>

