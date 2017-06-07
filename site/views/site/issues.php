<?php
/**
 * @var \yii\data\ArrayDataProvider $issues
 * @var array $buttons
 */
use yii\bootstrap\ButtonGroup;
echo ButtonGroup::widget([
    'buttons' => $buttons
]);
echo \yii\widgets\ListView::widget(
    [
        'dataProvider' => $issues,
        'itemView' => function ($model) {
            return $this->render('_list_item', ['issue' => $model]);
        },
    ]
);