<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/21/2015
 * Time: 5:18 PM
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\helpers\UtilHelper;
use backend\assets\ArrangementAsset;

/* @var $this yii\web\View */

$this->title = 'Sắp xếp sản phẩm nổi bật | ' . Yii::$app->name;

ArrangementAsset::register($this);

?>

<article class="site-index">
    <div class="container-fluid">
        <h2>Sắp xếp sản phẩm nổi bật</h2>
        <div class="row">
            <div class="col-6 related pr-0">
                <div class="portlet">
                    <div class="portlet-title">
                        <h4>Sản phẩm đã chọn</h4>
                    </div>
                    <div class="portlet-body">
                        <ul class="connected list sortable grid" id="arrangementSelected">
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
            <div class="col-6 search">
                <div class="portlet">
                    <div class="portlet-title">
                        <h4>Tất cả sản phẩm</h4>
                    </div>
                    <div class="portlet-body">
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
                <div class="action-buttons d-flex justify-content-end mt-3 mb-3">
                    <?php $form = ActiveForm::begin([
                        'id' => 'arrangement-form'
                    ]); ?>
                    <input id="arrangementProduct" type="hidden" name="ArrangementProduct" value="" />
                    <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success mr-3']) ?>
                    <?= Html::a('Quay lại', ['index'], ['class' => 'btn btn-secondary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</article>


