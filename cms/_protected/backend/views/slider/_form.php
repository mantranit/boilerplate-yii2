<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Content;
use yii\helpers\Url;
use backend\assets\SystemAsset;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $contentElement common\models\ContentElement */
/* @var $form yii\widgets\ActiveForm */

SystemAsset::register($this);

$this->registerJs("
    $('#content-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('widget/checkingduplicated') . "',
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
    $('.field-content-slug').on('click', function(){
        $(this).children('input')
            .prop('disabled', false)
            .focus();
    });
");


use mihaildev\elfinder\AssetsCallBack;
use mihaildev\elfinder\ElFinder;
use \yii\helpers\Json;

AssetsCallBack::register($this);

$buttonOptions = [
    'id' => 'el-button-banner',
    'type' => 'button',
    'class' => 'btn btn-primary'
];
$buttonOptions2 = [
    'id' => 'el-button-slide',
    'type' => 'button',
    'class' => 'btn btn-primary'
];
$managerOptions = [
    'language' => 'vi',
    'filter' => 'image',
    'path' => 'image',
    'callback' => 'el-banner',
    'width' => 'auto',
    'height' => 'auto'
];
$managerOptions['url'] = ElFinder::getManagerUrl('elfinder', $managerOptions);
$managerOptions['id'] = $managerOptions['callback'];

$managerOptions2 = [
    'language' => 'vi',
    'filter' => 'image',
    'path' => 'image',
    'callback' => 'el-slide',
    'width' => 'auto',
    'height' => 'auto'
];
$managerOptions2['url'] = ElFinder::getManagerUrl('elfinder', $managerOptions2);
$managerOptions2['id'] = $managerOptions2['callback'];

$this->registerJs("
    mihaildev.elFinder.register(" . Json::encode($managerOptions['id']) . ", function(file, id){
        $('#content-summary').val(file.url);
        $('.banner-content .image').html('<img src=\"' + file.url + '\" alt=\"\" />');
        return true;
    });
    mihaildev.elFinder.register(" . Json::encode($managerOptions2['id']) . ", function(file, id){
        $('#content-content').val(file.url);
        $('.slide-content .image').html('<img src=\"' + file.url + '\" alt=\"\" />');
        return true;
    });
"); // register callback Function
$this->registerJs("
    $(document).on('click', '#" . $buttonOptions['id'] . "', function(){
        mihaildev.elFinder.openManager(" . Json::encode($managerOptions) . ");
    });
    $(document).on('click', '#" . $buttonOptions2['id'] . "', function(){
        mihaildev.elFinder.openManager(" . Json::encode($managerOptions2) . ");
    });
");//on click button open manager


?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'id' => 'action-form'
    ]); ?>

    <div class="container-fluid">
        <div class="portlet">
            <div class="portlet-title"></div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-8">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>
                    </div>
                    <div class="col-4">
                        <?= $form->field($model, 'sorting') ?>
                    </div>
                </div>
<!--                --><?//= $form->field($model, 'summary')->hiddenInput() ?>
<!--                --><?//= $form->field($model, 'content')->hiddenInput() ?>

                <div class="form-group">
                    <label class="control-label">Desktop</label>
                    <div class="banner-content">
                        <span class="image">
                            <?php if($model->updated_date > 0) { ?>
                                <img src="<?= $model->summary ?>" alt="" />
                            <?php } ?>
                        </span>
                        <?= Html::button('Chọn', $buttonOptions);?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Phone</label>
                    <div class="slide-content">
                        <span class="image">
                            <?php if($model->content) { ?>
                                <img src="<?= $model->content ?>" alt="" />
                            <?php } ?>
                        </span>
                        <?= Html::button('Chọn', $buttonOptions2);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="action-buttons d-flex justify-content-end m-3">
        <input type="hidden" name="type-submit" value="" />
        <?= Html::submitButton($model->status === Content::STATUS_DRAFT ? 'Hiển thị' : 'Cập nhật',
            [
                'class' => 'btn btn-success mr-2',
                'data' => ['submit' => 1]
            ]) ?>
        <?php if($model->status === null || $model->status === Content::STATUS_DRAFT) { ?>
            <?= Html::submitButton($model->id ? 'Cập nhật tạm' : 'Lưu tạm',
                [
                    'class' => 'btn btn-primary mr-2',
                    'data' => ['submit' => 0]
                ]) ?>
        <?php } ?>
        <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
