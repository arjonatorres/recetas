<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

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
     * @param $i      El número de paso
     * @param $delete Booleano si hay que borrar la foto
     * @return bool Si se ha efectuado la subida correctamente.
     */
    public function upload($i, $delete = false)
    {
        $id = 'paso-' . $this->receta_id . '-' . $i;
        $ruta = Yii::$app->basePath . '/web/images/pasos/' . $id . '.jpg';
        if ($this->foto === null) {
            if ($delete) {
                unlink($ruta);
            }
            return true;
        }
        $res = $this->foto->saveAs($ruta);
        if ($res) {
            Image::thumbnail($ruta, 1024, 768)->save($ruta, ['quality' => 80]);
        }
        return $res;
    }

    /**
     * Devuelve la imagen del paso si existe
     * @param $id_receta   El id de la receta
     * @param $id_paso     La posición del paso
     * @return bool|string La ruta o false si no existe la imagen
     */
    public function getRutaImagen ($id_receta, $id_paso) {
        $rutaBase = Yii::$app->basePath . '/web/images/pasos/paso-';
        if (file_exists($rutaBase . $id_receta . '-' . $id_paso . '.jpg')) {
            $ruta = '@web/images/pasos/paso-'. $id_receta . '-' . $id_paso . '.jpg';
        } else {
            $ruta = false;
        }
        return $ruta;
    }

    /**
     * Devuelve la imagen local del paso
     * @param $id_receta   El id de la receta
     * @param $id_paso     La posición del paso
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getRutaPaso($id_receta, $id_paso)
    {
        $id = $this->id;

        $ruta = 'images/pasos/paso-' . $id_receta . '-' . $id_paso . '.jpg';
        if (file_exists($ruta)) {
            return $ruta;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceta()
    {
        return $this->hasOne(Recetas::className(), ['id' => 'receta_id'])->inverseOf('pasos');
    }
}
