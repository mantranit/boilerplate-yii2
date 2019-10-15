<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\assets\SystemAsset;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý banner';
$this->params['breadcrumbs'][] = $this->title;

SystemAsset::register($this);

?>
<article class="page-index container-fluid">
    <h2>
        <?= Html::encode($this->title) ?>
        <div class="actions">
            <?= $this->render('_popup') ?>
        </div>
    </h2>
    <div class="portlet">
        <div class="portlet-body p-0 pb-3 system" data-url="<?= Url::toRoute(['sorting']) ?>">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(['id' => 'widgets']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-borderless table-hover'],
                'layout' => '{items}<div class="controls">{pager}{summary}</div>',
                'pager' => [
                    'class' => 'yii\bootstrap4\LinkPager',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'name',
                        'format'=>'html',
                        'value'=> function($data) {
                            return Html::a($data->name, ['update', 'id' => $data->id]);
                        }
                    ],
                    [
                        'header' => 'Position',
                        'value' => function($data) {
                            switch($data->parent_id) {
                                case 2:{
                                    return 'Cột trái';
                                    break;
                                }
                                case 1:{
                                    return 'Scroll phải';
                                    break;
                                }
                                case 0:
                                default: {
                                    return 'Scroll trái';
                                    break;
                                }
                            }
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->getStatusList(),
                        'value' => function($data) {
                            return $data->statusName;
                        }
                    ],
                    [
                        'attribute' => 'show_in_menu',
                        'format'=>'raw',
                        'value' => function($data) {
                            return Html::a('', ['active', 'id' => $data->id],
                                [
                                    'title'=>'Kích hoạt',
                                    'class' => $data->show_in_menu === 1 ? 'fa fa-check' : 'fa fa-remove',
                                    'data' => [
                                        'confirm' => "Bạn muốn đổi trạng thái?",
                                        'method' => 'post']
                                ]);
                        }
                    ],
                    // buttons
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => "Menu",
                        'template' => '{update} &nbsp; {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('', $url, ['title'=>'Manage widget',
                                    'class'=>'fa fa-pencil-square-o']);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('', $url,
                                    [
                                        'title'=>'Delete page',
                                        'class'=>'fa fa-trash-o',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this page?'),
                                            'method' => 'post']
                                    ]);
                            }
                        ]
                    ], // ActionColumn
                ],
            ]); ?>
        </div>
    </div>
</article>
