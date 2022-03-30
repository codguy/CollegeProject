<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notification as NotificationModel;

/**
 * Notification represents the model behind the search form of `app\models\Notification`.
 */
class Notification extends NotificationModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'state_id', 'to_user_id', 'created_by_id'], 'integer'],
            [['username', 'title', 'type_id', 'model_id', 'created_on'], 'safe'],
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
        $query = NotificationModel::find();

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
            'state_id' => $this->state_id,
            'to_user_id' => $this->to_user_id,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'model_id', $this->model_id]);

        return $dataProvider;
    }
}
