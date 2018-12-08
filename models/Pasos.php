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
     * Contiene la foto del paso subida en el formulario.
     * @var UploadedFile
     */
    public $foto;

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
            [['foto'], 'file', 'extensions' => 'jpg, png'],
            [['foto'], 'file', 'maxSize' => 1024 * 1024 * 8, 'message' => 'La foto tiene que ser menor de 8MB'],
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
            'foto' => 'Foto'
        ];
    }

    /**
     * Guarda fotos
     * @param $i    El número de paso
     * @return bool Si se ha efectuado la subida correctamente.
     */
    public function upload($i)
    {
        if ($this->foto === null) {
            return true;
        }
        $id = 'paso-' . $this->receta_id . '-' . $i;
        $ruta = Yii::$app->basePath . '/web/images/pasos/' . $id . '.' . $this->foto->extension;
        $res = $this->foto->saveAs($ruta);
        return $res;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceta()
    {
        return $this->hasOne(Recetas::className(), ['id' => 'receta_id'])->inverseOf('pasos');
    }
}
