<?php
/**
 * @var common\models\Comment $model
 */

$this->title = "Update comment #$model->id";

echo $this->render('_form', compact('model'));