<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\helpers\UtilHelper;
use yii\widgets\Pjax;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="product-index pb-3">
    <div class="container-fluid">
        <h2>
            Danh sách sản phẩm
            <div class="actions">
                <?= $this->render('_popup') ?>
            </div>
        </h2>
        <div class="portlet">
            <div class="portlet-body">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
        <div class="portlet mt-4">
            <div class="portlet-body p-0 pb-3">
                <?php Pjax::begin(['id' => 'products', 'options' => ['class' => 'w-100']]) ?>
                <?= GridView::widget([
                    'tableOptions' => ['class' => 'table table-striped table-borderless table-hover'],
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'layout' => '{items}<div class="controls">{pager}{summary}</div>',
                    'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => '#',
                            'format' => 'html',
                            'value' => function($data) {
                                $img = UtilHelper::getPicture($data->image, 'thumb-list', true);
                                return Html::a(Html::img($img, ['width'=>'100']), ['update', 'id' => $data->id]);
                            }
                        ],
                        [
                            'attribute'=>'name',
                            'format'=>'html',
                            'value'=> function($data) {
                                return Html::a($data->name, ['update', 'id' => $data->id]);
                            }
                        ],
                        [
                            'attribute'=>'created_date',
                            'format'=>['date', 'php: d/m/Y'],
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => $searchModel->getStatusList(),
                            'value' => function($data) {
                                return $data->statusName;
                            }
                        ],
                        [
                            'header' => 'Hiển thị',
                            'format' => 'raw',
                            'value' => function($data) {
                                return Html::a('', ['active', 'id' => $data->id],
                                    [
                                        'class' => intval($data->activated) === 1 ? 'active fa fa-toggle-on' : 'active fa fa-toggle-off',
                                        'title' => 'Publish',
                                        'data' => [
                                            'confirm' => "Are you sure you want to change state this category?",
                                            'method'=>"post"
                                        ]
                                    ]);
                            }
                        ],
                        // buttons
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => "Menu",
                            'template' => '{preview} &nbsp; {update} &nbsp; {delete}',
                            'buttons' => [
                                'preview' => function ($url, $model, $key) {
                                    return Html::a(
                                    '',
                                        '/san-pham/' . $model->slug . '.html',
                                        ['title'=>'Preview', 'target' => '_blank', 'class'=>'fa fa-eye']
                                    );
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('', $url, ['title'=>'Manage product',
                                        'class'=>'fa fa-pencil-square-o']);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('', $url,
                                        ['title'=>'Delete product',
                                            'class'=>'fa fa-trash-o',
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Are you sure you want to delete this product?'),
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

<?php
$this->registerJs("
$('#products').on('click', '.active', function(e){
    var url = $(this).attr('href') + '?ajax=1';
    $.post(url, function(){
        $.pjax.reload({container: '#products'});
    });
    return false;
});
");
?>
