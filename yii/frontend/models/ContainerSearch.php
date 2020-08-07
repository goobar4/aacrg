<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Container;

/**
 * ContainerSearch represents the model behind the search form of `frontend\models\Container`.
 */
class ContainerSearch extends Container
{
    
    
    public function attributes()
    {
        
        return array_merge(parent::attributes(), ['prepType0.value', 'containerType0.value']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['containerId', 'prepType0.value', 'fixative', 'containerStatus', 'isDeleted', 'containerType0.value', 'parId'], 'trim'],
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
        $query = Container::find()
        ->where('prepType <> 29');

        $query->joinWith(['prepType0' => function ($query) {
            $query->from(['prepType0' => 'service']);
        }]);
        $query->joinWith(['containerType0' => function ($query) {
            $query->from(['containerType0' => 'service']);
        }]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        $dataProvider->sort->attributes['prepType0.value'] = [
            'asc' => ['prepType0.value' => SORT_ASC],
            'desc' => ['prepType0.value' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['containerType0.value'] = [
            'asc' => ['containerType0.value' => SORT_ASC],
            'desc' => ['containerType0.value' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
           return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'containerId', $this->containerId])
            ->andFilterWhere(['like', 'prepType0.value', $this->getAttribute('prepType0.value')])
            ->andFilterWhere(['like', 'fixative', $this->fixative])
            ->andFilterWhere(['=', 'containerStatus', $this->containerStatus])
            ->andFilterWhere(['like', 'containerType0.value', $this->getAttribute('containerType0.value')])
            ->andFilterWhere(['like', 'parId', $this->parId])
            ->andFilterWhere(['like', 'isDeleted', $this->isDeleted]);

        return $dataProvider;
    }
}
