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
            [['titulo', 'ingredientes', 'categoria_id'], 'required'],
            [['comensales'], 'number'],
            [['categoria_id'], 'default', 'value' => null],
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
    public function upload()
    {
        if ($this->foto === null) {
            return true;
        }
        $id = 'receta' . $this->id;
        $ruta = Yii::$app->basePath . '/web/images/recetas/' . $id . '.' . $this->foto->extension;
        $res = $this->foto->saveAs($ruta);
        return $res;
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
