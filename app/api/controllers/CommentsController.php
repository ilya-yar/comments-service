<?php

namespace api\controllers;

use yii\rest\ActiveController;

/**
 * Comment controller for API
 */
class CommentsController extends ActiveController
{
    public $modelClass = 'common\models\Comment';
}
