<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PublicRow;

/**
 * MemberSearch represents the model behind the search form about `common\models\Member`.
 */
class PublicRowSearch extends PublicRow {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['member_id', 'is_chu'], 'integer'],
                [['send_money'], 'number'],
                [['order_id'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return PublicRow::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = PublicRow::find()->select('{{%public_row}}.*, {{%member}}.nick_name as nick_name')->leftJoin('{{%member}}', '{{%public_row}}.member_id = {{%member}}.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'send_money' => $this->send_money,
        ]);

        return $dataProvider;
    }

}
