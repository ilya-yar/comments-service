<?php

namespace common\models;

use yii\data\ActiveDataProvider;

/**
 * Comment filter model
 */
class CommentFilter extends Comment
{
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['subject' => $this->subject])
            ->andFilterWhere(['subject_id' => $this->subject_id])
            ->andFilterWhere(['username' => $this->username])
            ->andFilterWhere(['created_at' => $this->created_at]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => 1000
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ]
        ]);

        return $provider;
    }
}
