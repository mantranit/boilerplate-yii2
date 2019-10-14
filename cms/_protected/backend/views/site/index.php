<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ArrangementAsset;

/* @var $this yii\web\View */
$this->title = Yii::t('app', Yii::$app->name);

ArrangementAsset::register($this);

?>

<article class="site-index pb-3">
    <div class="container-fluid">
        <h2>Thông tin</h2>
        <div class="portlet">
            <?php $form = ActiveForm::begin([
                'id' => 'config-form'
            ]); ?>
            <div class="portlet-title">
                <h4>&nbsp;</h4>
                <div class="actions">
                    <button type="button" class="btn btn-lg btn-link"  data-toggle="collapse" data-target="#formInfo" aria-expanded="true"><i class="fa fa-compress"></i></button>
                </div>
            </div>
            <div class="portlet-body collapse show" id="formInfo">
                <div class="row">
                    <?php foreach ($config as $index => $item) { ?>
                        <div class="<?= $item->key === 'ADDRESS' ? 'col-12' : 'col-6' ?>">
                            <div class="form-group">
                                <label class="control-label" for="config-item-<?= $index+1 ?>"><?= Yii::t('app', $item->key) ?></label>
                                <?= Html::input('text', 'Config['.$item->key.']', $item->value, ['class' => 'form-control', 'id' => 'config-item-'.($index+1)]) ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="action-buttons">
                        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success mr-2']) ?>
                        <?= Html::a('Bỏ qua', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="container-fluid">
        <h2>SEO Chính</h2>
        <div class="portlet">
            <?php $form = ActiveForm::begin([
                'id' => 'seo-form'
            ]); ?>
            <div class="portlet-title">
                <h4>&nbsp;</h4>
                <div class="actions">
                    <button type="button" class="btn btn-lg btn-link" data-toggle="collapse" data-target="#formSeo" aria-expanded="true"><i class="fa fa-compress"></i></button>
                </div>
            </div>
            <div class="portlet-body collapse show" id="formSeo">
                <div class="row">
                <?php foreach ($seo as $index => $item) { ?>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="control-label" for="config-item-<?= $index+1 ?>"><?= Yii::t('app', $item->key) ?></label>
                            <?= Html::textarea('Seo['.$item->key.']', $item->value, ['class' => 'form-control', 'rows' => $index+3, 'id' => 'config-item-'.($index+1)]) ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div class="row">
                    <div class="action-buttons">
                        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success mr-2']) ?>
                        <?= Html::a('Bỏ qua', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="container-fluid">
        <h2>SEO Social</h2>
        <div class="portlet">
            <?php $form = ActiveForm::begin([
                'id' => 'social-form'
            ]); ?>
            <div class="portlet-title">
                <h4>&nbsp;</h4>
                <div class="actions">
                    <button type="button" class="btn btn-lg btn-link" data-toggle="collapse" data-target="#formSocial" aria-expanded="true"><i class="fa fa-compress"></i></button>
                </div>
            </div>
            <div class="portlet-body collapse show" id="formSocial">
                <div class="row">
                <?php foreach ($social as $index => $item) { ?>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="control-label" for="config-item-<?= $index+1 ?>"><?= Yii::t('app', $item->key) ?></label>
                            <?= Html::input('text', 'Social['.$item->key.']', $item->value, ['class' => 'form-control', 'id' => 'social-item-'.($index+1)]) ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div class="row">
                    <div class="action-buttons">
                        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success mr-2']) ?>
                        <?= Html::a('Bỏ qua', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="container-fluid">
        <h2>Hỗ trợ</h2>
        <div class="portlet">
            <?php $form = ActiveForm::begin([
                'id' => 'social-form'
            ]); ?>
            <div class="portlet-title">
                <h4>&nbsp;</h4>
                <div class="actions">
                    <?= Html::a('<i class="fa fa-plus"></i>', 'javascript:void(0);', ['class' => 'add-support btn btn-lg btn-link', 'title' => 'Thêm thông tin hỗ trợ']) ?>
                    <button type="button" class="btn btn-lg btn-link" data-toggle="collapse" data-target="#formSupport" aria-expanded="true"><i class="fa fa-compress"></i></button>
                </div>
            </div>
            <div class="portlet-body collapse show" id="formSupport">
                <div class="row">
                    <ul class="support-config col-12">
                        <?php foreach ($support as $index => $contact) { ?>
                            <li class="contact contact-item-<?= ($index) ?>" data-index="<?= ($index) ?>">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="control-label"><?= Yii::t('app', 'Type') ?></label>
                                            <?= Html::dropDownList('Support['.($index).'][type]', $contact['type'], ['yahoo' => 'Yahoo', 'skype' => 'Skype'], ['class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="control-label"><?= Yii::t('app', 'Name') ?></label>
                                            <?= Html::textInput('Support['.($index).'][name]', $contact['name'], ['class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="control-label"><?= Yii::t('app', 'Nickname') ?></label>
                                            <?= Html::textInput('Support['.($index).'][nickname]', $contact['nickname'], ['class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="control-label"><?= Yii::t('app', 'Phone') ?></label>
                                            <?= Html::textInput('Support['.($index).'][phone]', $contact['phone'], ['class' => 'form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <label style="display: block">&nbsp;</label>
                                            <a class="remove-suport" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="row">
                    <div class="action-buttons">
                        <?= Html::submitButton('Cập nhật', ['name' => 'Support[submit]', 'class' => 'btn btn-success mr-2']) ?>
                        <?= Html::a('Bỏ qua', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</article>

