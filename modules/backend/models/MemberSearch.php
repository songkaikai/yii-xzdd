<?php

namespace app\modules\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Member;

/**
 * MemberSearch represents the model behind the search form about `common\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'reg_time', 'status', 'recommender', 'level'], 'integer'],
            [['uno', 'uname', 'nick_name', 'true_name', 'route', 'sex'], 'safe'],
            [['commissions', 'balance'], 'number'],
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
        $query = Member::find()
                ->alias('a')
                ->select('a.*, b.nick_name as recommend_name')
                ->leftJoin('{{%member}} b', 'a.recommender=b.id');

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
            'a.id' => $this->id,
            'a.reg_time' => $this->reg_time,
            'a.status' => $this->status,
            'a.recommender' => $this->recommender,
            'a.level' => $this->level,
            'a.commissions' => $this->commissions,
            'a.balance' => $this->balance,
        ]);

        $query->andFilterWhere(['like', 'a.uno', $this->uno])
            ->andFilterWhere(['like', 'a.uname', $this->uname])
            ->andFilterWhere(['like', 'a.nick_name', $this->nick_name])
            ->andFilterWhere(['like', 'a.true_name', $this->true_name])
            ->andFilterWhere(['like', 'a.route', $this->route]);

        return $dataProvider;
    }
}
