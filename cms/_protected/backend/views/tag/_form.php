<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
    $('#tag-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('tag/checkingduplicated') . "',
            {'name': name" . ($model->id ? ", 'id': $model->id" : '') . "},
            function(data){
                if(data === true){
                    that.parent().removeClass('duplicated');
                } else {
                    that.parent().addClass('duplicated');
                }
            }
        );
    });
");

?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="container-fluid">
        <div class="portlet">
            <div class="portlet-title"></div>
            <div class="portlet-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

                <div class="action-buttons pr-0">
                    <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => 'btn btn-success mr-3']) ?>
                    <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
