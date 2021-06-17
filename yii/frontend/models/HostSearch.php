<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Host;

/**
 * HostSearch represents the model behind the search form of `frontend\models\Host`.
 */
class HostSearch extends Host
{
   public $pagination = 20;
   
    /**
     * {@inheritdoc}
     */

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'sciName0.scientificName', 'sexValue.value',
            'ageValue.value', 'placeName0.province', 'placeName0.country', 'placeName0.localityName'
        ]);
    }
    public function rules()
    {
        return [
            [[
                'occurrenceID', 'sexValue.value', 'ageValue.value', 'occurenceDate', 'sciName0.scientificName',
                'isDeleted', 'isEmpty', 'placeName0.province', 'placeName0.country', 'placeName0.localityName'
            ], 'trim'],

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
        $query = Host::find();

        $query->joinWith(['sciName0' => function ($query) {
            $query->from(['sciName0' => 'taxonomy']);
        }]);
        $query->joinWith(['placeName0' => function ($query) {
            $query->from(['placeName0' => 'locality']);
        }]);
        $query->joinWith(['sexValue' => function ($query) {
            $query->from(['sexValue' => 'service']);
        }]);
        $query->joinWith(['ageValue' => function ($query) {
            $query->from(['ageValue' => 'service']);
        }]);
       $query->leftJoin('service spr', 'placeName0.province = spr.id');
       $query->leftJoin('service scount', 'placeName0.country = scount.id');



        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pagination,
            ],
        ]);

        $dataProvider->sort->attributes['sciName0.scientificName'] = [
            'asc' => ['sciName0.scientificName' => SORT_ASC],
            'desc' => ['sciName0.scientificName' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['placeName0.localityName'] = [
            'asc' => ['placeName0.localityName' => SORT_ASC],
            'desc' => ['placeName0.localityName' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['sexValue.value'] = [
            'asc' => ['sexValue.value' => SORT_ASC],
            'desc' => ['sexValue.value' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['ageValue.value'] = [
            'asc' => ['ageValue.value' => SORT_ASC],
            'desc' => ['ageValue.value' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['like', 'occurrenceID', $this->occurrenceID])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'age', $this->age])
            ->andFilterWhere(['like', 'isDeleted', $this->isDeleted])
            ->andFilterWhere(['=', 'isEmpty', $this->isEmpty])
            ->andFilterWhere(['like', 'natureOfRecord', $this->natureOfRecord])
            ->andFilterWhere(['like', 'occurenceDate', $this->occurenceDate])
            ->andFilterWhere(['like', 'sciName0.scientificName', $this->getAttribute('sciName0.scientificName')])
            ->andFilterWhere(['like', 'placeName0.localityName', $this->getAttribute('placeName0.localityName')])
            ->andFilterWhere(['like', 'spr.value', $this->getAttribute('placeName0.province')])
            ->andFilterWhere(['like', 'scount.value', $this->getAttribute('placeName0.country')])
            ->andFilterWhere(['=', 'sexValue.value', $this->getAttribute('sexValue.value')])
            ->andFilterWhere(['like', 'ageValue.value', $this->getAttribute('ageValue.value')]);

        return $dataProvider;
    }
}
