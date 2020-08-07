<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Storage;

/**
 * StorageSearch represents the model behind the search form of `frontend\models\Storage`.
 */
class StorageSearch extends Storage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7'], 'safe'],
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
        $query = Storage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'item1', $this->item1])
            ->andFilterWhere(['like', 'item2', $this->item2])
            ->andFilterWhere(['like', 'item3', $this->item3])
            ->andFilterWhere(['like', 'item4', $this->item4])
            ->andFilterWhere(['like', 'item5', $this->item5])
            ->andFilterWhere(['like', 'item6', $this->item6])
            ->andFilterWhere(['like', 'item7', $this->item7]);

        return $dataProvider;
    }
}
