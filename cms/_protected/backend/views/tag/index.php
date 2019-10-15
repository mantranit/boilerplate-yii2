<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý Tag';
?>
<article class="tag-index pb-3">
    <div class="container-fluid">
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
                        // buttons
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => "Menu",
                            'template' => '{update} &nbsp; {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('', $url, ['title'=>'Manage tag',
                                        'class'=>'fa fa-pencil-square-o']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('', $url,
                                        ['title'=>'Delete tag',
                                            'class'=>'fa fa-trash-o',
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Are you sure you want to delete this tag?'),
                                                'method' => 'post']
                                        ]);
                                }
                            ]
                        ], // ActionColumn
                    ],
                ]); ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>

</article>
