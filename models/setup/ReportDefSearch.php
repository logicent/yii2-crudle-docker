<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportDef;

class ReportDefSearch extends ReportDef
{

    public function rules()
    {
        return [
            [['id', 'name', 'ref_code', 'module', 'is_standard', 'type', 'source_table',
                'query_cmd', 'dataset', 'criteria', 'js_code', 'allow_roles',
                'created_by', 'updated_by', 'created_at', 'updated_at', 'comments'], 'safe'],
            [['add_total_sums', 'use_permissions', 'hidden'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ReportDef::find();

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
            'add_total_sums' => $this->add_total_sums,
            'use_permissions' => $this->use_permissions,
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ref_code', $this->ref_code])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'is_standard', $this->is_standard])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'source_table', $this->source_table])
            ->andFilterWhere(['like', 'query_cmd', $this->query_cmd])
            ->andFilterWhere(['like', 'dataset', $this->dataset])
            ->andFilterWhere(['like', 'criteria', $this->criteria])
            ->andFilterWhere(['like', 'js_code', $this->js_code])
            ->andFilterWhere(['like', 'allow_roles', $this->allow_roles]);

        return $dataProvider;
    }
}
