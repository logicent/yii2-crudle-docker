<?php

namespace app\models\setup;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\setup\Report;

/**
 * ReportSearch represents the model behind the search form of `app\models\setup\Report`.
 */
class ReportSearch extends Report
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'module', 'type', 'query_cmd', 'dataset', 'criteria', 'js_code', 'allow_roles', 'created_at', 'created_by', 'updated_at', 'updated_by', 'comments'], 'safe'],
            [['add_sum_total', 'use_permissions', 'hidden'], 'integer'],
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
        $query = Report::find();

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
            'add_sum_total' => $this->add_sum_total,
            'use_permissions' => $this->use_permissions,
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'query_cmd', $this->query_cmd])
            ->andFilterWhere(['like', 'dataset', $this->dataset])
            ->andFilterWhere(['like', 'criteria', $this->criteria])
            ->andFilterWhere(['like', 'js_code', $this->js_code])
            ->andFilterWhere(['like', 'allow_roles', $this->allow_roles])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
