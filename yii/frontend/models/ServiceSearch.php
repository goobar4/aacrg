<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Service;

/**
 * ServiceSearch represents the model behind the search form of `frontend\models\Service`.
 */
class ServiceSearch extends Service
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['value', 'target','_table'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Service::find();

        // add conditions that should always apply here

        $query->where(['<>','target','prepType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', '_table', $this->_table]);

        return $dataProvider;
    }
}
