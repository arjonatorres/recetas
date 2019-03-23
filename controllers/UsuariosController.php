<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Query;

class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::ESCENARIO_CREATE]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->mailer->compose(
                    'validacion',
                    ['token' => $model->token_val]
                )
                    ->setFrom([Yii::$app->params['adminEmail'] => 'Recetas Family'])
                    ->setTo($model->email)
                    ->setSubject('Validar usuario')
                    ->send();
                Yii::$app->session->setFlash(
                    'info',
                    'Su cuenta ha sido creada correctamente. Para activar '
                    . 'su cuenta pulse en el enlace del email que se le ha enviado.'
                );
                return $this->goHome();
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param null $token
     * @return Response
     */
    public function actionValidar($token = null)
    {
        if ($token !== null) {
            $usuario = Usuarios::findOne(['token_val' => $token]);
            if ($usuario !== null) {
                $usuario->token_val = null;
                $usuario->save();
                Yii::$app->session->setFlash(
                    'success',
                    'Su cuenta ha sido activada correctamente.'
                );
                return $this->redirect(['site/login']);
            }
        }
        return $this->goHome();
    }

    /**
     * Updates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = Usuarios::ESCENARIO_UPDATE;
        $model->password = '';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->foto = UploadedFile::getInstance($model, 'foto');
            $model->updated_at =  date('Y-m-d H:i:s');
            $deleteFotoPerfil = isset($_POST['usuarios-foto']);
            if ($model->save() && $model->upload($deleteFotoPerfil)) {
                Yii::$app->session->setFlash('info','Su cuenta ha sido actualizada correctamente');
                return $this->goHome();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, usuario AS text')
                ->from('usuarios')
                ->where(['ilike', 'usuario', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Usuarios::find($id)->usuario];
        }
        return $out;
    }
}
