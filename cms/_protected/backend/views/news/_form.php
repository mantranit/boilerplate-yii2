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
            '" . Url::toRoute('news/checkingduplicated') . "',
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
        <div class="row">
            <div class="col-9">
                <div class="portlet">
                    <div class="portlet-title">
                        <h4></h4>
                        <div class="actions">
                            <button type="button" class="btn btn-lg btn-link" data-toggle="collapse" data-target="#newsContent" aria-expanded="true"><i class="fa fa-compress"></i></button>
                        </div>
                    </div>
                    <div class="portlet-body collapse show" id="newsContent">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>
                        <?= $form->field($model, 'summary')->textarea(['row' => 5]) ?>
                        <?= $form->field($model, 'content')->widget('mihaildev\ckeditor\CKEditor', [
                            'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],
                                array_merge(Yii::$app->params['toolbarContent'], [
                                    'height' => 600
                                ])
                            ),
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-3 pl-0">
                <div class="portlet">
                    <div class="portlet-title">
                        <h4>Tags</h4>
                        <div class="actions">
                            <button type="button" class="btn btn-lg btn-link" data-toggle="collapse" data-target="#newsTags" aria-expanded="true"><i class="fa fa-compress"></i></button>
                        </div>
                    </div>
                    <div class="portlet-body collapse show" id="newsTags">
                        <textarea id="tags" rows="1" name="Tag" data-value='<?= Html::decode($tags) ?>' data-suggestions="<?= Html::decode($tagSuggestions) ?>"></textarea>
                    </div>
                </div>
                <div class="portlet mt-3">
                    <div class="portlet-title">
                        <h4>Hình ảnh</h4>
                        <div class="actions">
                            <button type="button" class="btn btn-lg btn-link" data-toggle="collapse" data-target="#newsPicture" aria-expanded="true"><i class="fa fa-compress"></i></button>
                        </div>
                    </div>
                    <div class="portlet-body collapse show" id="newsPicture">
                        <div id="filelist" class="view-thumbnail">
                            <?php
                            foreach ($pictures as $index => $item) {
                                ?>
                                <div id="<?= $item->id ?>" class="photo-zone">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr><td class="controls">
                                                <label><input type="radio" name="Content[image_id]" value="<?= $item->id ?>" <?php if(intval($item->id) === intval($model->image_id)) echo 'checked="checked"'; ?> /> <?= Yii::t('app', 'Main picture') ?></label>
                                                <a class="delete-image" data-id="<?= $item->id ?>" href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                            </td></tr>
                                        <tr><td class="edit"><span class="name">
                                    <img src="<?= $item->show_url ?><?= $item->name ?>-thumb-upload.<?= $item->file_ext ?>" alt="<?= $item->name ?>" />
                                </span></td></tr>
                                        <tr><td class="caption">
                                                <textarea rows="4" name="Picture[<?= $item->id ?>][caption]" placeholder="Say something about this photo."><?= $item->caption ?></textarea>
                                                <input type="hidden" name="Picture[<?= $item->id ?>][id]" value="<?= $item->id ?>"/>
                                            </td></tr>
                                    </table></div>
                            <?php } ?>
                        </div>
                        <div id="uploader" data-upload-link="<?=Url::toRoute('image/create')?>">
                            <a id="pickfiles" href="javascript:;" class="btn btn-success">Select files</a>
                        </div>
                        <pre id="console"></pre>
                    </div>
                </div>
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
