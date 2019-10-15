<?php

Yii::setAlias('@uploads', __DIR__ . '/../../../uploads');

return [
    'bsVersion' => '4.x',
    'image_maximum_size' => 1600,
    'image_sizes' => [
        'thumb-upload' => [300, 220],
        'thumb-list' => [120, 90],
    ]
];
