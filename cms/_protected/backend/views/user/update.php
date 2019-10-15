<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $role common\rbac\models\Role; */

$this->title = 'Cập nhật người dùng';
?>
<article class="user-update">
    <div class="container-fluid">
        <h2>
            <?= Html::encode($this->title) ?>
            <div class="actions">
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-lg btn-link']) ?>
            </div>
        </h2>
    </div>
    <?= $this->render('_form', [
        'user' => $user,
        'role' => $role,
    ]) ?>
</article>
