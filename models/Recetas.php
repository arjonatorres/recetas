<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recetas".
 *
 * @property int $id
 * @property string $titulo
 * @property string $historia
 * @property string $ingredientes
 * @property string $comensales
 * @property string $comentarios
 * @property int $categoria_id
 * @property int $usuario_id
 * @property string $created_at
 *
 * @property Pasos[] $pasos
 * @property Categorias $categoria
 * @property Usuarios $usuario
 */
class Recetas extends \yii\db\ActiveRecord
{
    /**
     * Contiene la foto principal de la receta subida en el formulario.
     * @var UploadedFile
     */
    public $foto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recetas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'ingredientes', 'categoria_id', 'comensales'], 'required'],
            [['comensales'], 'number'],
            [['historia', 'comentarios'], 'default', 'value' => null],
            [['categoria_id'], 'integer'],
            [['created_at'], 'safe'],
            [['titulo'], 'string', 'max' => 255],
            [['historia', 'ingredientes', 'comentarios'], 'string', 'max' => 10000],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['!usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['foto'], 'file', 'extensions' => 'jpg, png'],
            [['foto'], 'file', 'maxSize' => 1024 * 1024 * 8, 'message' => 'La foto principal tiene que ser menor de 8MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'historia' => 'Historia',
            'ingredientes' => 'Ingredientes',
            'comensales' => 'Comensales',
            'comentarios' => 'Comentarios',
            'categoria_id' => 'Categoria',
            'usuario_id' => 'Usuario ID',
            'created_at' => 'Created At',
            'foto' => 'Foto principal'
        ];
    }

    /**
     * Guarda fotos
     * @return bool Si se ha efectuado la subida correctamente.
     */
    public function upload($delete = false)
    {
        $id = 'receta' . $this->id;
        $ruta = Yii::$app->basePath . '/web/images/recetas/' . $id . '.jpg';
        if ($this->foto === null) {
            if ($delete) {
                unlink($ruta);
            }
            return true;
        }
        $res = $this->foto->saveAs($ruta);
        return $res;
    }

    /**
     * Devuelve la imagen de la receta si existe
     * @return bool|string La ruta o false si no existe la imagen
     */
    public function getRutaImagen () {
        $rutaBase = Yii::$app->basePath . '/web/images/recetas/receta';
        if (file_exists($rutaBase . $this->id . '.jpg')) {
            $ruta = '@web/images/recetas/receta' . $this->id . '.jpg';
        } else {
            $ruta = false;
        }
        return $ruta;
    }

    /**
     * Devuelve la imagen local de la receta
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getRutaReceta()
    {
        $id = $this->id;

        $ruta = 'images/recetas/receta' . $id . '.jpg';
        if (file_exists($ruta)) {
            return $ruta;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasos()
    {
        return $this->hasMany(Pasos::className(), ['receta_id' => 'id'])->inverseOf('receta');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id'])->inverseOf('recetas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('recetas');
    }
}
