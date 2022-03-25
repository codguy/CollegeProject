<?php
namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblUser as TblUserModel;

/**
 * TblUser represents the model behind the search form of `app\models\TblUser`.
 */
class TblUser extends TblUserModel
{

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'roll_id',
                    'state_id',
                    'created_by_id'
                ],
                'integer'
            ],
            [
                [
                    'username',
                    'email',
                    'password',
                    'dob',
                    'created_on',
                    'authKey',
                    'accessToken',
                    'gender',
                    'profile_picture'
                ],
                'safe'
            ]
        ];
    }

    /**
     *
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
        $query = TblUserModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'roll_id' => $this->roll_id,
            'state_id' => $this->state_id,
            'dob' => $this->dob,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id
        ]);

        $query->andFilterWhere([
            'like',
            'username',
            $this->username
        ])
            ->andFilterWhere([
            'like',
            'email',
            $this->email
        ])
            ->andFilterWhere([
            'like',
            'password',
            $this->password
        ])
            ->andFilterWhere([
            'like',
            'authKey',
            $this->authKey
        ])
            ->andFilterWhere([
            'like',
            'accessToken',
            $this->accessToken
        ])
            ->andFilterWhere([
            'like',
            'gender',
            $this->gender
        ])
            ->andFilterWhere([
            'like',
            'profile_picture',
            $this->profile_picture
        ]);

        return $dataProvider;
    }
}
