<?php

namespace app\modules\backend\models;

use Yii;
use app\models\Withdraw;
use yii\data\ActiveDataProvider;
use yii\base\Model;

/**
 * Description of WithdrawSearch
 *
 * @author Administrator
 */
class WithdrawSearch extends Withdraw {

    public $nick_name;
    public $startDate;
    public $endDate;
    public $uname;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['pay_no', 'nick_name', 'withdraw_type', 'uname'], 'string', 'max' => 32],
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
        $query = Withdraw::find()->leftJoin('{{%member}}', '{{%withdraw}}.member_id = {{%member}}.id')->select('{{%withdraw}}.*, {{%member}}.nick_name, {{%member}}.uname')->orderBy('{{%withdraw}}.add_time desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{%withdraw}}.withdraw_type' => $this->withdraw_type,
            '{{%withdraw}}.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'pay_no', $this->pay_no])
                ->andFilterWhere(['like', '{{%member}}.uname', $this->uname])
                ->andFilterWhere(['like', '{{%member}}.nick_name', $this->nick_name]);

        return $dataProvider;
    }

}
