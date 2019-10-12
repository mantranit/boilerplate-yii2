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
        <label>Tên sản phẩm</label>
        <input type="text" name="name" />
    </div>
    <div class="action-buttons">
        <button class="small radius">Tạo mới</button>
    </div>
</form>

