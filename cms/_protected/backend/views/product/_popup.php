<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/20/2015
 * Time: 11:18 AM
 */

use yii\helpers\Url;

?>

<form action="<?= Url::toRoute(['create']) ?>">
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" />
    </div>
    <div class="action-buttons">
        <button class="btn btn-success">Tạo mới</button>
    </div>
</form>

