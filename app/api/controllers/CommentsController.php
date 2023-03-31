<?php

namespace api\controllers;

use common\models\CommentFilter;
use yii\rest\ActiveController;

/**
 * Comment controller for API
 */
class CommentsController extends ActiveController
{
    public $modelClass = 'common\models\Comment';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $filter = new CommentFilter();
        $filter->load(\Yii::$app->request->get(), '');

        return $filter->search();
    }
}
