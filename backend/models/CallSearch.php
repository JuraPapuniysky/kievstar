<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Call;

/**
 * CallSearch represents the model behind the search form of `common\models\Call`.
 */
class CallSearch extends Call
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'catalog_id', 'created_at', 'updated_at'], 'integer'],
            [['date_time', 'type', 'call_directions', 'phone'], 'safe'],
            [['cost_balance', 'cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Call::find();

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
            'date_time' => $this->date_time,
            'cost_balance' => $this->cost_balance,
            'cost' => $this->cost,
            'catalog_id' => $this->catalog_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'call_directions', $this->call_directions])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
