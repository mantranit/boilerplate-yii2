<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
    $('#category-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('category/checkingduplicated') . "',
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
    $('.field-category-slug').on('click', function(){
        $(this).children('input')
            .prop('disabled', false)
            .focus();
    });
");

?>

<div class="category-form">
    <?php $form = ActiveForm::begin(); ?>
        <?php $this->beginBlock('content'); ?>
        <div class="container-fluid">
            <div class="portlet">
                <div class="portlet-title"></div>
                <div class="portlet-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($model->getParents($model->id, 0, 0), 'id', 'name'), ['prompt'=>'- please select -']) ?>

                    <?= $form->field($model, 'description')->widget('mihaildev\ckeditor\CKEditor', [
                        'editorOptions' => array_merge(Yii::$app->params['toolbarDescription'], [
                            'height' => 300
                        ]),
                    ]) ?>

                    <?= $form->field($model, 'general')->widget('mihaildev\ckeditor\CKEditor', [
                        'editorOptions' => array_merge(Yii::$app->params['toolbarContent'], [
                            'height' => 500
                        ]),
                    ]) ?>
                </div>
            </div>
        </div>
        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('seo'); ?>
        <div class="container-fluid">
            <div class="portlet">
                <div class="portlet-title"></div>
                <div class="portlet-body">
                    <?php if($model->slug !== null) { ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => 128]) ?>
                    <?php } ?>
                    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 128]) ?>
                    <?= $form->field($model, 'seo_keyword')->textarea(['maxlength' => 128, 'rows' => 2]) ?>
                    <?= $form->field($model, 'seo_description')->textarea(['maxlength' => 256, 'rows' => 5]) ?>
                </div>
            </div>
        </div>
        <?php $this->endBlock(); ?>

        <?= Tabs::widget([
            'options' => ['class' => 'nav-tabs--product'],
            'items' => [
                [
                    'label' => 'Nội dung',
                    'content' => $this->blocks['content'],
                ],
                [
                    'label' => 'SEO',
                    'content' => $this->blocks['seo'],
                ],
            ],
        ]);
        ?>
    <div class="action-buttons d-flex justify-content-end m-3">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => 'btn btn-success mr-3']) ?>
        <?= Html::a('Quay lại', Url::toRoute(['index']), ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
