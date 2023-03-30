<?php

namespace api\controllers;

use common\models\Comment;
use common\models\CommentFilter;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
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

        // You may load filters from any source. For example,
        // if you prefer JSON in request body,
        // use Yii::$app->request->getBodyParams() below:
        $filter->load(\Yii::$app->request->get());
        // TODO https://stackoverflow.com/questions/36300972/yii2-rest-api-actions-in-activecontroller

       // echo $filter->search()->query->createCommand()->getRawSql(); exit;

        return $filter->search();
    }
}
