<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Content;
use yii\helpers\Url;
use backend\assets\PageBuilderAsset;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap4\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $contentElement common\models\ContentElement */
/* @var $form yii\widgets\ActiveForm */

PageBuilderAsset::register($this);

$this->registerJs("
    $('#content-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('page/checkingduplicated') . "',
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

?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'id' => 'action-form'
    ]); ?>

        <?php $this->beginBlock('content'); ?>
        <div class="container-fluid">
            <div class="portlet">
                <div class="portlet-title"></div>
                <div class="portlet-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>

                    <?= $form->field($model, 'using_page_builder')->radioList([0 => Yii::t('app', 'Normal Editor'), 1 => Yii::t('app', 'Page Builder')]) ?>

                    <aside class="normal-editor radio-group radio-item-0" <?= intval($model->using_page_builder) === 1 ? 'style="display: none"' : '' ?> >

                        <?= $form->field($model, 'content')->widget('mihaildev\ckeditor\CKEditor', [
                            'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],
                                array_merge(Yii::$app->params['toolbarContent'], [
                                    'height' => 600
                                ])
                            ),
                        ]) ?>
                    </aside>
                    <aside class="page-builder-editor radio-group radio-item-1" <?= intval($model->using_page_builder) === 0 ? 'style="display: none"' : '' ?> >
                        <br/>
                        <div class="page-builder" data-href="<?= Url::toRoute(['content-element/index', 'contentId' => $model->id]) ?>">
                            <div class="controls">
                                <?= Html::a('', ['content-element/create', 'contentId' => $model->id, 'type' => 'row'], ['class' => 'add-e-pb fa fa-plus', 'title' => 'Add new row']) ?>
                            </div>
                        </div>
                        <br/>
                    </aside>
                </div>
            </div>
        </div>
        <?php $this->endBlock() ?>

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
        <?php $this->endBlock() ?>

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
            <input type="hidden" name="type-submit" value="" />
            <?= Html::submitButton($model->status === Content::STATUS_DRAFT ? 'Hiển thị' : 'Cập nhật',
                [
                    'class' => 'btn btn-success mr-3',
                    'data' => ['submit' => 1]
                ]) ?>
            <?php if($model->status === null || $model->status === Content::STATUS_DRAFT) { ?>
                <?= Html::submitButton($model->id ? 'Cập nhật tạm' : 'Lưu tạm',
                    [
                        'class' => 'btn btn-primary mr-3',
                        'data' => ['submit' => 0]
                    ]) ?>
            <?php } ?>
            <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
