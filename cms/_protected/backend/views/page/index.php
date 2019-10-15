<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý trang';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="page-index container-fluid pb-3">
    <h2>
        <?= Html::encode($this->title) ?>
        <div class="actions">
            <?= $this->render('_popup') ?>
        </div>
    </h2>
    <div class="portlet">
        <div class="portlet-body p-0 pb-3">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(['id' => 'tags']) ?>
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
                        'attribute' => 'created_date',
                        'format'=>['date', 'php: d/m/Y'],
                        'filter'=>false,
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->getStatusList(),
                        'value' => function($data) {
                            return $data->statusName;
                        }
                    ],
                    // buttons
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => "Kích hoạt",
                        'template' => '{show-in-menu}',
                        'buttons' => [
                            'show-in-menu' => function ($url, $model, $key) {
                                return Html::a('', $url,
                                    ['title'=>'Show In Menu',
                                        'class'=>intval($model->show_in_menu) === 1 ? 'fa fa-check' : 'fa fa-remove',
                                        'data' => ['method' => 'post']
                                    ]);
                            },
                        ]
                    ], // ActionColumn
                    // buttons
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => "Menu",
                        'template' => '{update} &nbsp; {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('', $url, ['title'=>'Manage page',
                                    'class'=>'fa fa-pencil-square-o']);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('', $url,
                                    ['title'=>'Delete page',
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
