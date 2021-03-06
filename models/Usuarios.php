<?php

namespace app\models;

use Yii;
use yii\imagine\Image;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $usuario
 * @property string $password
 * @property string $email
 * @property string $auth_key
 * @property string $token_val
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Recetas[] $recetas
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const ESCENARIO_CREATE = 'create';
    const ESCENARIO_UPDATE = 'update';
    public $password_repeat;

    /**
     * Contiene la foto del usuario subida en el formulario.
     * @var UploadedFile
     */
    public $foto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario', 'email'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => self::ESCENARIO_CREATE],
            [['usuario', 'password', 'password_repeat', 'email'], 'string', 'max' => 255],
            [
                ['password_repeat'],
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty' => false,
                'on' => [self::ESCENARIO_CREATE, self::ESCENARIO_UPDATE],
            ],
            [['token_val'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['usuario'], 'unique'],
            [['email'], 'email'],
            [['foto'], 'file', 'extensions' => 'jpg, png'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir Contraseña',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Guarda foto de perfil
     * @return bool Si se ha efectuado la subida correctamente.
     */
    public function upload($delete = false)
    {
        $ruta = Yii::$app->basePath . '/web/images/avatar/' . $this->id . '.jpg';
        if ($this->foto === null) {
            if ($delete) {
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
            }
            return true;
        }

        $res = $this->foto->saveAs($ruta);
        if ($res) {
            Image::thumbnail($ruta, 300, 300)->save($ruta, ['quality' => 80]);
        }
        return $res;
    }

    /**
     * Devuelve la imagen local
     * @return bool|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getRutaImagen()
    {
        $id = $this->id;

        $ruta = 'images/avatar/' . $id . '.jpg';
        if (file_exists($ruta)) {
            return $ruta;
        }
        return 'images/avatar/0.png';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecetas()
    {
        return $this->hasMany(Recetas::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    public function getRutaAvatar ($id = null) {
        if ($id == null) {
            $id = Yii::$app->user->id;
        }
        $rutaBase = Yii::$app->basePath . '/web/images/avatar/';
        if (file_exists($rutaBase . $id . '.jpg')) {
            $ruta = '@web/images/avatar/' . $id . '.jpg';
        } else {
            $ruta = '@web/images/avatar/0.png';
        }
        return $ruta;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
//                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->token_val = Yii::$app->security->generateRandomString();
                if ($this->scenario === self::ESCENARIO_CREATE) {
                    $this->password = Yii::$app->security->generatePasswordHash($this->password);
                }
            } else {
                if ($this->scenario === self::ESCENARIO_UPDATE) {
                    if ($this->password === '') {
                        $this->password = $this->getOldAttribute('password');
                    } else {
                        $this->password = Yii::$app->security->generatePasswordHash($this->password);
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            // $result = Yii::$app->mailer->compose(
            //     'validacion',
            //     ['token' => $this->token_val]
            // )
            //     ->setFrom(Yii::$app->params['adminEmail'])
            //     ->setTo('arjonatorres79@gmail.com')
            //     ->setSubject('Validar usuario')
            //     ->send();
        }
    }
}
