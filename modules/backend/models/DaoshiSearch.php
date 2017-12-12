<?php

namespace app\modules\backend\models;

use app\models\Daoshituan;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContentSearch represents the model behind the search form about `app\models\Content`.
 */
class DaoshiSearch extends Daoshituan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sorts'], 'integer'],
            [['nick_name', 'team_name'], 'string', 'max' => 50],
            [['wechat_no'], 'string', 'max' => 30],
            [['wechat_code', 'avatar'], 'string', 'max' => 100],
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
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize=20)
    {
        $query = static::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=>SORT_DESC]],
            'pagination' => ['pageSize'=>$pageSize]
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
            'wechat_no' => $this->wechat_no,
        ]);

        $query->andFilterWhere(['like', 'nick_name', $this->nick_name])
            ->andFilterWhere(['like', 'team_name', $this->team_name]);

        return $dataProvider;
    }
}
