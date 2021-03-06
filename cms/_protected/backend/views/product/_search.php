<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search form-no-label form-one-line">

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
                <?= Html::submitButton('<i class="fa fa-filter"></i>', ['class' => 'btn btn-success']) ?>
                <?php if(isset(Yii::$app->request->queryParams) && count(Yii::$app->request->queryParams)) { ?>
                <?= Html::a('<i class="fa fa-times"></i>', Url::toRoute(['index']), ['class' => 'btn btn-secondary']) ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
