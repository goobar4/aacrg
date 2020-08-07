<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;


/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function attributes()
	{
		// делаем поле зависимости доступным для поиска
		return array_merge(parent::attributes(), ['role.item_name']);
		
	}

    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'name','surname','auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'role.item_name'], 'safe'],
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
        $query = User::find();
       // $query->joinWith(['role']);
        $query->joinWith(['role' => function($query) { $query->from(['role' => 'auth_assignment']); }])
        ->where(['role.item_name' => 'admin'])
        ->orWhere(['role.item_name' => 'user'])
        ->orWhere(['role.item_name' => 'guest'])
        ->orWhere(['role.item_name' => null])
        ->orWhere(['role.item_name' => 'nonactive']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['role.item_name'] = [
            'asc' => ['role.item_name' => SORT_ASC],
            'desc' => ['role.item_name' => SORT_DESC],
            ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'item_name' => $this->getAttribute('role.item_name'),
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'role.item_name', $this->getAttribute('role.item_name')]);

        return $dataProvider;
    }
}
