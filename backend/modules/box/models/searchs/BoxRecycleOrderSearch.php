<?php

namespace backend\modules\box\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\box\models\BoxRecycleOrder;

/**
 * BoxRecycleOrderSearch represents the model behind the search form about `backend\modules\box\models\BoxRecycleOrder`.
 */
class BoxRecycleOrderSearch extends BoxRecycleOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id','engineer_id', 'region_id', 'sex', 'service_type', 'price', 'reward_price', 'status', 'source'], 'integer'],
            [['order_no', 'link_name', 'mobile', 'address', 'expect_start_dt', 'expect_end_dt', 'create_dt', 'update_dt', 'remarks'], 'safe'],
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
        $query = BoxRecycleOrder::find()
                    ->joinWith(['assignUser' , 'region']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'engineer_id' => $this->engineer_id,
            'box_recycle_order.region_id' => $this->region_id,
            'sex' => $this->sex,
            'service_type' => $this->service_type,
            'price' => $this->price,
            'reward_price' => $this->reward_price,
            'box_recycle_order.status' => $this->status,
            'expect_start_dt' => $this->expect_start_dt,
            'expect_end_dt' => $this->expect_end_dt,
            'source' => $this->source,
            'update_dt' => $this->update_dt,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'link_name', $this->link_name])
            ->orFilterWhere(['like', 'mobile', $this->link_name])
            ->orFilterWhere(['exception' => !empty($this->status) ? abs($this->status) : ''])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'box_recycle_order.remarks', $this->remarks])
            ->andFilterWhere(['>=', 'create_dt', $this->create_dt])
            ->andFilterWhere(['<', 'create_dt', !empty($this->create_dt) ? date('Y-m-d H:i:s' , strtotime($this->create_dt.'+1 day')) : $this->create_dt]);

        return $dataProvider;
    }
}
