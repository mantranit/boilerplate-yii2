<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý người dùng';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="user-index pb-3">
    <div class="container-fluid">
        <h2>
            <?= Html::encode($this->title) ?>
            <div class="actions">
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-lg btn-link']) ?>
            </div>
        </h2>

        <div class="portlet">
            <div class="portlet-body p-0 pb-3">
                <?php Pjax::begin(['id' => 'colors']) ?>
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
                        'username',
                        'full_name',
                        //'email:email',
                        // status
                        [
                            'attribute'=>'status',
                            'filter' => $searchModel->statusList,
                            'value' => function ($data) {
                                return $data->statusName;
                            },
                            'contentOptions'=>function($model, $key, $index, $column) {
                                return ['class'=>CssHelper::statusCss($model->statusName)];
                            }
                        ],
                        // role
                        [
                            'attribute'=>'item_name',
                            'filter' => $searchModel->rolesList,
                            'value' => function ($data) {
                                return $data->roleName;
                            },
                            'contentOptions'=>function($model, $key, $index, $column) {

                                return ['class'=>CssHelper::roleCss($model->roleName)];
                            }
                        ],
                        // buttons
                        ['class' => 'yii\grid\ActionColumn',
                        'header' => "Menu",
                        'template' => '{update} &nbsp; {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('', $url, ['title'=>'Manage user',
                                        'class'=>'fa fa-pencil-square-o']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('', $url,
                                    ['title'=>'Delete user',
                                        'class'=>'fa fa-trash-o',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                                            'method' => 'post']
                                    ]);
                                }
                            ]
                        ], // ActionColumn
                    ], // columns
                ]); ?>
                <?php Pjax::end() ?>
            </div>
        </div>

    </div>
</article>
