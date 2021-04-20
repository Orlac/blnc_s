<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class HistorySearch extends History
{

    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
        ];
    }


    public function search($user_id = null)
    {
        $query = History::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ],
        ]);

        $this->load([
            'user_id' => $user_id
        ]);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['user_id' => $this->user_id]);
        return $dataProvider;
    }

    public function getUserBalance($user_id)
    {
        $this->load([
            'user_id' => $user_id
        ]);

        if (!$this->validate()) {
            return;
        }
        // return 4;
        $query = History::find()
            ->orderBy(['id' => SORT_DESC]);
        $query->andWhere(['user_id' => $this->user_id]);

        return $query->one();
    }
}
