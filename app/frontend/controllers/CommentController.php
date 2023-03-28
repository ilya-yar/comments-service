<?php

namespace frontend\controllers;

use Yii;
use common\models\Comment;
use common\models\CommentFilter;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Comment controller
 */
class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'index', 'update'],
                'rules' => [
                    // Allow creating comments for guests
                    [
                        'actions' => ['create', 'index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    // Allow updating comments for authorized users
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $filter = new CommentFilter();

        $get = Yii::$app->request->get();
        $filter->load($get);

        return $this->render('index', compact('filter'));
    }

    public function actionUpdate(int $id)
    {
        $model = Comment::findOne(['id' => $id]);
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Record not found!');
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success','Saved successfully!');
                return $this->redirect(\Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('error', 'Saving error!');
            }
        }

        return $this->render('update', ['model' => $model]);
    }
}
