<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Locality;

/**
 * LocalitySearch represents the model behind the search form of `frontend\models\Locality`.
 */
class LocalitySearch extends Locality
{
    
    public function attributes()
    {
        
        return array_merge(parent::attributes(), ['country0.value', 'province0.value']);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'decimalLatitude', 'decimalLongitude'], 'integer'],
            [['localityName', 'province', 'country', 'typeHabitate','country0.value', 'province0.value'], 'trim'],
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
        $query = Locality::find();

        $query->joinWith(['province0' => function ($query) {
            $query->from(['province0' => 'service']);
        }]);

        $query->joinWith(['country0' => function ($query) {
            $query->from(['country0' => 'service']);
        }]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['province0.value'] = [
            'asc' => ['province0.value' => SORT_ASC],
            'desc' => ['province0.value' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['country0.value'] = [
            'asc' => ['country0.value' => SORT_ASC],
            'desc' => ['country0.value' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['like', 'localityName', $this->localityName])
            ->andFilterWhere(['like', 'province0.value', $this->getAttribute('province0.value')])
            ->andFilterWhere(['like', 'country0.value', $this->getAttribute('country0.value')])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'typeHabitate', $this->typeHabitate]);

        return $dataProvider;
    }
}
