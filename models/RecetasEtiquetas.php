<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recetas_etiquetas".
 *
 * @property int $receta_id
 * @property int $etiqueta_id
 *
 * @property Etiquetas $etiqueta
 * @property Recetas $receta
 */
class RecetasEtiquetas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recetas_etiquetas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receta_id', 'etiqueta_id'], 'required'],
            [['receta_id', 'etiqueta_id'], 'default', 'value' => null],
            [['receta_id', 'etiqueta_id'], 'integer'],
            [['receta_id', 'etiqueta_id'], 'unique', 'targetAttribute' => ['receta_id', 'etiqueta_id']],
            [['etiqueta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etiquetas::className(), 'targetAttribute' => ['etiqueta_id' => 'id']],
            [['receta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recetas::className(), 'targetAttribute' => ['receta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receta_id' => 'Receta ID',
            'etiqueta_id' => 'Etiqueta ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiqueta()
    {
        return $this->hasOne(Etiquetas::className(), ['id' => 'etiqueta_id'])->inverseOf('recetasEtiquetas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceta()
    {
        return $this->hasOne(Recetas::className(), ['id' => 'receta_id'])->inverseOf('recetasEtiquetas');
    }
}
