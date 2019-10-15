<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/20/2015
 * Time: 11:18 AM
 */

use yii\helpers\Url;
use yii\bootstrap4\Modal;

?>
<?php
Modal::begin([
    'title' => 'Thêm mới',
    'toggleButton' => [
        'label' => '<i class="fa fa-plus"></i>',
        'class' => 'btn btn-lg btn-link'
    ],
]);
?>
<form action="<?= Url::toRoute(['create']) ?>">
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Tag" />
    </div>
    <div class="action-buttons">
        <button class="btn btn-success">Tạo mới</button>
    </div>
</form>
<?php Modal::end(); ?>
