<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\enums\CommentStatus;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Comment model
 *
 * @property integer $id
 * @property string $subject
 * @property integer $subject_id
 * @property string $username
 * @property string $comment
 * @property string $status
 * @property string $useragent
 * @property string $ip
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'subject_id'], 'integer'],
            [['subject', 'username', 'comment', 'useragent'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['created_at', 'updated_at'], 'date', 'format' => 'Y-m-d H:m:s'],
            [['status'], 'in', 'range' => [CommentStatus::getValues()]],
        ];
    }

    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->status = CommentStatus::NEW;
            $this->created_at = $this->created_at ?: date('Y-m-d H:i:s');
        }
        $this->updated_at = date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getColumns(): array
    {
        return [
            'subject',
            'subject_id',
            'username',
            'created_at',
            'comment' => [
                'attribute' => 'comment',
                'format' => 'raw',
                'value' => function (Comment $model) {
                   return substr($model->comment, 0, 150);
                },
            ],
            [
                'label' => 'actions',
                'format' => 'raw',
                'value' => function (Comment $model) {
                    return Html::a('Update', Url::to(['comments/update', 'id' => $model->id]));
                },
                'visible' => !\Yii::$app->user->isGuest
            ]
        ];
    }
}
