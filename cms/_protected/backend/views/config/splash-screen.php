<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/21/2015
 * Time: 4:07 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\models\Config;

/* @var $this yii\web\View */

$this->title = 'Cấu hình chung | ' . Yii::$app->name;

?>

<article class="site-index">
    <div class="container-fluid">
        <h2>Cấu hình chung</h2>

        <div class="portlet">
            <div class="portlet-title">

            </div>
            <div class="portlet-body">
                <?php
                $enabled = Config::findOne(['key' => 'POPUP_ENABLED'])->value;
                $form = ActiveForm::begin([
                    'id' => 'general-form'
                ]); ?>

                <label class="form-group-enabled">
                    <input type="checkbox" value="1" name="popup_enabled" <?= $enabled ? 'checked="checked"' : '' ?>/>
                    <span>Hiển thị popup chào mừng.</span>
                </label>

                <div class="form-group">
                    <label class="form-group-enabled">Cấu hình popup.</label>
                    <input type="text" class="form-control" name="popup_options" value="<?= Config::findOne(['key'=>'POPUP_OPTIONS'])->value ?>" />
                </div>

                <div class="popup-content">
                    <?= CKEditor::widget([
                        'name' => 'popup_content',
                        'value' => Config::findOne(['key' => 'POPUP_CONTENT'])->value,
                        'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],[
                            'inline' => false,
                            'language' => 'vi',
                            'toolbar' => [
                                ['name' => 'styles', 'items' => [ 'Format' ]],
                                ['name' => 'document', 'items' => [ 'Templates' ]],
                                ['name' => 'basicstyles', 'items' => [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ]],
                                ['name' => 'paragraph', 'items' => [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Blockquote']],
                                ['name' => 'insert', 'items' => [ 'Table', 'Image', 'Smiley', 'Iframe']],
                                ['name' => 'links', 'items' => [ 'Link', 'Unlink', 'Anchor' ]],
                                ['name' => 'clipboard', 'items' => ['PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']],
                                ['name' => 'tools', 'items' => [ 'Maximize' ]],
                            ],
                            'height' => 300
                        ]),
                    ]) ?>
                </div>

                <div class="action-buttons d-flex justify-content-end m-3">
                    <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success mr-3']) ?>
                    <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</article>


