<?php

namespace app\models;

use Yii;

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
 *
 * @property Recetas[] $recetas
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
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
            [['usuario', 'password', 'email'], 'required'],
            [['created_at'], 'safe'],
            [['usuario', 'password', 'email', 'auth_key', 'token_val'], 'string', 'max' => 255],
            [['token_val'], 'unique'],
            [['usuario'], 'unique'],
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
            'password' => 'Password',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecetas()
    {
        return $this->hasMany(Recetas::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
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
}
