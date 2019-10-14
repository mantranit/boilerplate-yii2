<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ProductAsset;
use yii\helpers\Url;
use common\models\Product;
use common\models\Category;
use yii\helpers\Json;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\helpers\UtilHelper;
use common\helpers\CurrencyHelper;
use yii\bootstrap4\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */

ProductAsset::register($this);

$this->registerJs("
    $('#product-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('product/checkingduplicated') . "',
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
    $('.field-product-slug').on('click', function(){
        $(this).children('input')
            .prop('disabled', false)
            .focus();
    });
");

?>

<div class="product-form">

<?php $form = ActiveForm::begin([
    'id' => 'action-form'
]); ?>

<?php $this->beginBlock('information'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="portlet">
                <div class="portlet-title">
                    <h4>Thông tin</h4>
                    <div class="actions">
                        <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#productName" aria-expanded="true"><i class="fa fa-compress"></i></button>
                    </div>
                </div>
                <div class="portlet-body collapse show" id="productName">
                <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>
                <?= $form->field($model, 'description')->widget('mihaildev\ckeditor\CKEditor', [
                        'editorOptions' => array_merge(Yii::$app->params['toolbarIntro'], [
                            'height' => 300
                        ]),
                    ]) ?>
                </div>
            </div>

            <div class="portlet mt-3">
                <div class="portlet-title">
                    <h4>Quản lý giá</h4>
                    <div class="actions">
                        <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#productPrice" aria-expanded="true"><i class="fa fa-compress"></i></button>
                    </div>
                </div>
                <div class="portlet-body collapse show " id="productPrice">
                    <div class="price-zone">
                        <?php foreach (Json::decode($model->price_string) as $index => $prices) { ?>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="form-input">Giá bảo hành <?= strpos($index, '3') > 0 ? 3 : 12 ?> tháng</div>
                                    </div>
                                </div>
                                <?php foreach ($prices as $key => $value) { ?>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label"><span><?= Yii::t('app', $key) ?></span></label>
                                            <?php if($index === 'month3' && $key === 'current') { ?>
                                                <?= Html::textInput('Price['.$index.']['.$key.']', (intval($value) !== 0 ? $value : CurrencyHelper::formatNumber($model->price)), ['class'=>'form-control money-input']) ?>
                                            <?php } else { ?>
                                                <?= Html::textInput('Price['.$index.']['.$key.']', $value, ['class'=>'form-control money-input']) ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="portlet mt-3">
                <div class="portlet-title">
                    <h4>Hình sản phẩm</h4>
                    <div class="actions">
                        <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#productImages" aria-expanded="true"><i class="fa fa-compress"></i></button>
                    </div>
                </div>
                <div class="portlet-body collapse show " id="productImages">
                    <div id="filelist" class="view-thumbnail row">
                    <?php
                    foreach ($pictures as $index => $item) {
                        ?>
                        <div id="<?= $item->id ?>" class="photo-zone col-4">
                            <table cellpadding="0" cellspacing="0">
                                <tr><td class="controls">
                                        <label><input type="radio" name="Product[image_id]" value="<?= $item->id ?>" <?php if(intval($item->id) === intval($model->image_id)) echo 'checked="checked"'; ?> /> Hình chính</label>
                                        <a class="delete-image" data-id="<?= $item->id ?>" href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                    </td></tr>
                                <tr><td class="edit"><span class="name">
                                            <a class="various" data-fancybox-type="iframe" href="<?= Url::toRoute(['file/watermask', 'id' => $item->id]) ?>">
                                        <img src="<?= $item->show_url ?><?= $item->name ?>-thumb-upload.<?= $item->file_ext ?>" alt="<?= $item->name ?>" />
                                            </a>
                                    </span></td></tr>
                                <tr><td class="caption">
                                        <textarea rows="4" name="Picture[<?= $item->id ?>][caption]" placeholder="Say something about this photo."><?= $item->caption ?></textarea>
                                        <input type="hidden" name="Picture[<?= $item->id ?>][id]" value="<?= $item->id ?>"/>
                                    </td></tr>
                            </table></div>
                    <?php } ?>
                    </div>
                    <div id="uploader" data-upload-link="<?=Url::toRoute('image/create')?>">
                        <a id="pickfiles" href="javascript:;" class="btn btn-sm btn-success mt-3">Select files</a>
                    </div>
                    <pre id="console"></pre>
                </div>
            </div>
        </div>

        <div class="col-3 pl-0">
            <div class="portlet">
                <div class="portlet-title">
                    <h4></h4>
                    <div class="actions">
                        <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#productHighlight" aria-expanded="true"><i class="fa fa-compress"></i></button>
                    </div>
                </div>
                <div class="portlet-body collapse show" id="productHighlight">
                    <?php if($model->status !== Product::STATUS_DRAFT) { ?>
                        <?= $form->field($model, 'status')->dropDownList($model->getStatusListEdit()) ?>
                    <?php } ?>
                    <?= $form->field($model, 'is_hot')->checkbox() ?>
                    <?= $form->field($model, 'is_discount')->checkbox() ?>
                    <!-- <?= $form->field($model, 'discount')->textInput(['value' => CurrencyHelper::formatNumber($model->discount), 'class' => 'money-input']) ?> -->
                </div>
            </div>

            <div class="portlet mt-3">
                <div class="portlet-title">
                    <h4>Danh mục</h4>
                    <div class="actions">
                        <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#productCategory" aria-expanded="true"><i class="fa fa-compress"></i></button>
                    </div>
                </div>
                <div class="portlet-body collapse show" id="productCategory">
                    <script>
                    var treeData = [
                        <?php
                        $tree = Category::getTree();
                        $total = count($tree);
                        $categoryList = Json::decode($categories);
                        $htmlString = '';
                        foreach ($tree as $index => $papa) {
                            $htmlString .= '{title: "'.$papa['name'].'", isFolder: true, key: "'.$papa['id'].'"';
                            if(in_array(intval($papa['id']), $categoryList)) {
                                $htmlString .= ', select: true';
                            }

                            if(isset($papa['children'])) {
                                $total2 = count($papa['children']);
                                $htmlString .= ', children: [';
                                foreach ($papa['children'] as $inx => $child) {
                                    $htmlString .= '{title: "'.$child['name'].'", isFolder: true, key: "'.$child['id'].'"';
                                    if(in_array(intval($child['id']), $categoryList)) {
                                        $htmlString .= ', select: true';
                                    }
                                    if($inx < $total2 - 1) {
                                        $htmlString .= '},';
                                    }
                                    else {
                                        $htmlString .= '}';
                                    }
                                }
                                $htmlString .= ']';
                            }

                            if($index < $total - 1) {
                                $htmlString .= '},';
                            }
                            else {
                                $htmlString .= '}';
                            }
                        }

                        echo $htmlString;
                        ?>
                    ];
                    </script>
                    <div class="form-group">
                        <div id="tree2"></div>
                        <input id="echoSelection2" type="hidden" name="Category" value="<?= implode(',', $categoryList) ?>"/>
                    </div>
                </div>
            </div>

            <div class="portlet mt-3">
                <div class="portlet-title">
                    <h4>Thẻ</h4>
                    <div class="actions">
                        <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#productTags" aria-expanded="true"><i class="fa fa-compress"></i></button>
                    </div>
                </div>
                <div class="portlet-body collapse show" id="productTags">
                    <div class="form-group">
                        <textarea id="tags" rows="1" name="Tag" data-value='<?= Html::decode($tags) ?>' data-suggestions="<?= Html::decode($tagSuggestions) ?>"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
<div class="container-fluid">
    <div class="portlet">
        <div class="portlet-body">
            <nav>
                <div class="nav nav-tabs nav-fill" role="tablist">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#contentGeneral" role="tab">Tổng quan</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#contentTech" role="tab">Thông số kỹ thuật</a>
                </div>
            </nav>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="contentGeneral" role="tabpanel">
                    <div class="form-no-label">
                        <?= $form->field($model, 'general')->widget('mihaildev\ckeditor\CKEditor', [
                            'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],
                                array_merge(Yii::$app->params['toolbarContent'], [
                                    'height' => 600
                                ])
                            ),
                        ]) ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="contentTech" role="tabpanel">
                    <div class="form-no-label">
                        <?= $form->field($model, 'info_tech')->widget('mihaildev\ckeditor\CKEditor', [
                            'editorOptions' => array_merge(Yii::$app->params['toolbarIntro'], [
                                'height' => 600
                            ]),
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('seo'); ?>
<div class="container-fluid">
    <div class="portlet">
        <div class="portlet-title">
            <h4>Metadata</h4>
        </div>
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

<?php $this->beginBlock('related'); ?>
<input id="relatedProduct" type="hidden" name="Related" value="" />
<div class="container-fluid">
    <div class="row">
        <div class="col-6 pr-0">
            <div class="portlet">
                <div class="portlet-title">
                    <h4>Sản phẩm đã chọn</h4>
                </div>
                <div class="portlet-body related">
                    <ul class="connected list sortable grid">
                        <?php foreach ($products as $index => $item) {
                            $img = UtilHelper::getPicture($item->image, 'thumb-list', true);
                            ?>
                            <li data-id="<?= $item->id ?>" title="<?= $item->name ?>">
                                <img src="<?= $img ?>" alt="" />
                                <a href="javascript:;"><?= $item->name ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="portlet">
                <div class="portlet-title">
                    <h4>Tất cả sản phẩm</h4>
                </div>
                <div class="portlet-body search">
                    <div class="search-box">
                        <input type="text" placeholder="Enter keyword" class="form-control" />
                    </div>
                    <ul class="connected list no2">
                        <?php foreach ($productSuggestion as $index => $item) {
                            $img = UtilHelper::getPicture($item->image, 'thumb-list', true);
                            ?>
                            <li data-id="<?= $item->id ?>" title="<?= $item->name ?>">
                                <img src="<?= $img ?>" alt="" />
                                <a href="javascript:;"><?= $item->name ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<?= Tabs::widget([
        'options' => ['class' => 'nav-tabs--product'],
        'items' => [
            [
                'label' => 'Sản phẩm',
                'content' => $this->blocks['information'],
                'active' => true
            ],
            [
                'label' => 'Nội dung',
                'content' => $this->blocks['content'],
            ],
            [
                'label' => 'SEO',
                'content' => $this->blocks['seo'],
            ],
            [
                'label' => 'Sản phẩm liên quan',
                'content' => $this->blocks['related'],
            ],
        ],
    ]);
?>

    <div class="action-buttons d-flex justify-content-end m-3">
        <input type="hidden" name="type-submit" value="" />
        <?= Html::submitButton($model->status === Product::STATUS_DRAFT ? 'Hiển thị' : 'Cập nhật',
            [
                'class' => 'btn btn-success mr-2',
                'data' => ['submit' => 1]
            ]) ?>
        <?php if($model->status === null || $model->status === Product::STATUS_DRAFT) { ?>
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
