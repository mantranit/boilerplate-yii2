<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search form-no-label">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-3">
    <?php echo $form->field($model, 'name')->textInput(['placeholder' => 'Tên sản phẩm']) ?>
        </div>
        <div class="col-3">
    <?php echo $form->field($model, 'price_init')->dropDownList(Category::getTreeView(), ['prompt' => '- Danh mục -']) ?>
        </div>
        <div class="col-3">
    <?php echo $form->field($model, 'status')->dropDownList($model->getStatusList(), ['prompt' => '- Trạng thái -']) ?>
        </div>
        <div class="col-3">
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-success']) ?>
    </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
