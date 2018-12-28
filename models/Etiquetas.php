<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiquetas".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property RecetasEtiquetas[] $recetasEtiquetas
 * @property Recetas[] $recetas
 */
class Etiquetas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiquetas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecetasEtiquetas()
    {
        return $this->hasMany(RecetasEtiquetas::className(), ['etiqueta_id' => 'id'])->inverseOf('etiqueta');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecetas()
    {
        return $this->hasMany(Recetas::className(), ['id' => 'receta_id'])->viaTable('recetas_etiquetas', ['etiqueta_id' => 'id']);
    }
}
