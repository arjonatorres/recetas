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
            [['id', 'categoria_id', 'usuario_id', 'dificultad_id'], 'integer'],
            [['titulo', 'historia', 'created_at', 'ingredientes', 'tiempo'], 'safe'],
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


        // grid filtering conditions
        $query->andFilterWhere([
            'comensales' => $this->comensales,
            'categoria_id' => $this->categoria_id,
            'dificultad_id' => $this->dificultad_id,
//            'usuario_id' => $this->usuario_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo]);
        $query->andFilterWhere(['ilike', 'historia', $this->historia]);

        if (!empty($params)) {
            if (!empty($params['RecetasSearch']['etiqueta'])) {
                $etiquetas = $params['RecetasSearch']['etiqueta'];
                $models = $dataProvider->getModels();
                $numModels = count($models);

                for ($i = $numModels; $i > 0; $i--) {
                    $model = $models[$i-1];
                    foreach ($etiquetas as $etiqueta) {
                        $modelEtiquetas = array_column($model->etiquetas, 'nombre');
                        if (!in_array($etiqueta, $modelEtiquetas)) {
                            unset($models[$i-1]);
                        }
                    }
                }
                $dataProvider->setModels($models);
                $dataProvider->setTotalCount(count($models));
            }
            if (!empty($params['RecetasSearch']['ingredientes'])) {
                $ingredientes = explode(' ', $params['RecetasSearch']['ingredientes']);
                foreach ($ingredientes as $ingrediente) {
                    $query->andFilterWhere(['ilike', 'ingredientes', $ingrediente]);
                }
            }
        }
        
        $dataProvider->sort = ['defaultOrder' => ['created_at' => SORT_DESC]];
        $dataProvider->pagination->pageSize = 12;
        return $dataProvider;
    }
}
