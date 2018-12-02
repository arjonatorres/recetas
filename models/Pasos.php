<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pasos".
 *
 * @property int $id
 * @property string $texto
 * @property int $receta_id
 *
 * @property Recetas $receta
 */
class Pasos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['texto', 'receta_id'], 'required'],
            [['texto'], 'string', 'max' => 10000],
            [['receta_id'], 'default', 'value' => null],
            [['receta_id'], 'integer'],
            [['receta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recetas::className(), 'targetAttribute' => ['receta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Paso',
            'receta_id' => 'Receta ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceta()
    {
        return $this->hasOne(Recetas::className(), ['id' => 'receta_id'])->inverseOf('pasos');
    }
}
