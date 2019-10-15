<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = 'Cập nhật tag';
?>
<article class="tag-update">

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
    ]) ?>
</article>
