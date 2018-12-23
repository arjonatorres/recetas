<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dificultades".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Recetas[] $recetas
 */
class Dificultades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dificultades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 255],
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
    public function getRecetas()
    {
        return $this->hasMany(Recetas::className(), ['dificultad_id' => 'id'])->inverseOf('dificultad');
    }
}
