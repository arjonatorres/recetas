<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recetas;

/**
 * RecetasSearch represents the model behind the search form of `app\models\Recetas`.
 */
class RecetasSearch extends Recetas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'usuario_id'], 'integer'],
            [['titulo', 'historia', 'ingredientes', 'comentarios', 'created_at'], 'safe'],
            [['comensales'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Recetas::find();

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

        $dataProvider->sort = ['defaultOrder' => ['created_at' => SORT_ASC]];
        $dataProvider->pagination->pageSize = 12;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'comensales' => $this->comensales,
            'categoria_id' => $this->categoria_id,
            'usuario_id' => $this->usuario_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'historia', $this->historia])
            ->andFilterWhere(['ilike', 'ingredientes', $this->ingredientes])
            ->andFilterWhere(['ilike', 'comentarios', $this->comentarios]);

        return $dataProvider;
    }
}
