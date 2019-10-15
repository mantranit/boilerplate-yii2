<?php

use common\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $role common\rbac\models\Role; */
?>
<div class="user-form container-fluid">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>

    <div class="portlet">
        <div class="portlet-title"></div>
        <div class="portlet-body">
            <?= $form->field($user, 'username') ?>

            <?= $form->field($user, 'full_name') ?>
            <?= $form->field($user, 'email') ?>

            <?php if ($user->scenario === 'create'): ?>
                <?= $form->field($user, 'password')->widget('kartik\password\PasswordInput', []) ?>
            <?php else: ?>
                <?= $form->field($user, 'password')->widget('kartik\password\PasswordInput', [])
                    ->passwordInput(['placeholder' => 'Nhập mật khẩu mới nếu muốn thay đổi'])
                ?>
            <?php endif ?>

            <div class="large-12">

                <?= $form->field($user, 'status')->dropDownList($user->statusList) ?>

                <?php foreach (AuthItem::getRoles() as $item_name): ?>
                    <?php $roles[$item_name->name] = $item_name->name ?>
                <?php endforeach ?>
                <?= $form->field($role, 'item_name')->dropDownList(['member' => 'member', 'admin' => 'admin']) ?>

            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mt-3 mb-3">
        <?= Html::submitButton($user->isNewRecord ? 'Thêm mới'
            : 'Cập nhật', ['class' => 'btn btn-success mr-3']) ?>

        <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
