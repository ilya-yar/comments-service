<?php
/**
 * @var common\models\CommentFilter $filter
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $filter->search(),
    'filterModel' => $filter,
    'columns' => $filter->getColumns()
]);