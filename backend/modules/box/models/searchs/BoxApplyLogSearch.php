<?php

namespace backend\modules\box\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\box\models\BoxApplyLog;

/**
 * BoxApplyLogSearch represents the model behind the search form about `backend\modules\box\models\BoxApplyLog`.
 */
class BoxApplyLogSearch extends BoxApplyLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'status'], 'integer'],
            [['link_name', 'mobile', 'address', 'open_id', 'express_no', 'create_dt', 'remarks'], 'safe'],
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
        $query = BoxApplyLog::find()
                ->joinWith(['region']);;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'region_id' => $this->region_id,
            'box_apply_log.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'link_name', $this->link_name])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->orFilterWhere(['like', 'mobile', $this->link_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'open_id', $this->open_id])
            ->andFilterWhere(['like', 'express_no', $this->express_no])
            ->andFilterWhere(['>=', 'create_dt', $this->create_dt])
            ->andFilterWhere(['<', 'create_dt', !empty($this->create_dt) ? date('Y-m-d H:i:s' , strtotime($this->create_dt.'+1 day')) : $this->create_dt])
            ->andFilterWhere(['like', 'box_recycle_order.remarks', $this->remarks]);

        return $dataProvider;
    }
}
