<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrdersSearch extends Orders {

    public $nickName;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_no', 'goods_name', 'consignee', 'address', 'mobile', 'express', 'express_no', 'nickName'], 'safe'],
            [['member_id', 'order_type', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Orders::find()->leftJoin('{{%member}}', '{{%orders}}.member_id = {{%member}}.id')->select('{{%orders}}.*, {{%member}}.nick_name')->orderBy('pay_time desc');

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
            'member_id' => $this->member_id,
            'order_type' => $this->order_type,
            'goods_id' => $this->goods_id,
            'add_time' => $this->add_time,
            'pay_time' => $this->pay_time,
            '{{%orders}}.status' => $this->status,
            'over_time' => $this->over_time,
            'fh_time' => $this->fh_time,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
                ->andFilterWhere(['like', 'goods_name', $this->goods_name])
                ->andFilterWhere(['like', '{{%member}}.nick_name', $this->nickName])
                ->andFilterWhere(['like', 'consignee', $this->consignee])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'mobile', $this->mobile])
                ->andFilterWhere(['like', 'express', $this->express])
                ->andFilterWhere(['like', 'express_no', $this->express_no]);

        return $dataProvider;
    }

}
