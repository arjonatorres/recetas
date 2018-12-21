<?php

namespace app\controllers;

use Yii;
use app\models\Recetas;
use app\models\Categorias;
use app\models\Pasos;
use app\models\RecetasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\base\Model;
use yii\base\Exception;

/**
 * RecetasController implements the CRUD actions for Recetas model.
 */
class RecetasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all Recetas models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['site/index']);
    }

    /**
     * Displays a single Recetas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Recetas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $recetas = new Recetas(['usuario_id' => Yii::$app->user->id]);
        $pasos = new Pasos();
        $categorias = Categorias::find()->all();
        if (Yii::$app->request->isPost) {
            $recetas->load(Yii::$app->request->post());
            foreach (Yii::$app->request->post('Pasos') as $i => $data) {
                if (preg_match('/^foto/', $i) == 1) {
                    continue;
                }
                $newPasos = new Pasos();
                $newPasos->texto = $data;
                $newPasos->foto = UploadedFile::getInstance($newPasos, 'foto' . $i);
                $pasosArray[$i] = $newPasos;
            }
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $recetas->foto = UploadedFile::getInstance($recetas, 'foto');
                $valid = $recetas->validate();
                $valid = Model::validateMultiple($pasosArray, ['texto']) && $valid;
                if ($valid) {
                    $recetas->save(false);
                    foreach ($pasosArray as $i => $newPasos) {
                        $newPasos->receta_id = $recetas->id;
                        if ($newPasos->upload($i)) {
                            $newPasos->save(false);
                        } else {
                            throw new Exception();
                        }
                    }
                    if ($recetas->upload()) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $recetas->id]);
                    } else {
                        throw new Exception();
                    }
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger','Ha ocurrido un error al crear la Receta');
                return $this->goHome();
            }
        }

        return $this->render('create', [
            'model' => $recetas,
            'categorias' => $categorias,
            'pasos' => $pasos,
        ]);
    }

    /**
     * Updates an existing Recetas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->usuario_id != Yii::$app->user->id) {
            return $this->goHome();
        }

        $pasos = Pasos::findAll(['receta_id' => $model->id]);
        $categorias = Categorias::find()->all();

        if (Yii::$app->request->isPost) {

            $numPasosActual = 0;
            $model->load(Yii::$app->request->post());
            foreach (Yii::$app->request->post('Pasos') as $i => $data) {
                if (preg_match('/^foto/', $i) == 1) {
                    continue;
                }
                if (isset($pasos[$i])) {
                    $newPasos = $pasos[$i];
                } else {
                    $newPasos = new Pasos();
                }
                $newPasos->texto = $data;
                $newPasos->foto = UploadedFile::getInstance($newPasos, 'foto' . $i);
                $pasosArray[$i] = $newPasos;
                $numPasosActual++;
            }

            $numPasos = count($pasos);

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->foto = UploadedFile::getInstance($model, 'foto');
                $valid = $model->validate();
                $valid = Model::validateMultiple($pasosArray, ['texto']) && $valid;
                if ($valid) {
                    $model->save(false);
                    foreach ($pasosArray as $i => $newPasos) {
                        $newPasos->receta_id = $model->id;
                        $idHiddenFotoPaso = ($i == 0) ? 'pasos-foto' : 'pasos-foto-' . $i;
                        $deleteFotoPaso = isset($_POST[$idHiddenFotoPaso]);

                        if ($newPasos->upload($i, $deleteFotoPaso)) {
                            $newPasos->save(false);
                        } else {
                            throw new Exception();
                        }
                    }
                    for ($i = 1; $i <= ($numPasos - $numPasosActual); $i++) {
                        $pasoSobra = $pasos[($numPasos - $i)];
                        if ($pasoSobra->upload(($numPasos - $i), true)) {
                            $pasoSobra->delete();
                        } else {
                            throw new Exception();
                        }
                    }
                    $deleteFotoReceta = isset($_POST['recetas-foto']);
                    if ($model->upload($deleteFotoReceta)) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        throw new Exception();
                    }
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger','Ha ocurrido un error al editar la Receta');
                return $this->goHome();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categorias' => $categorias,
            'pasos' => $pasos,
        ]);
    }

    /**
     * Deletes an existing Recetas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $receta = $this->findModel($id);
        if ($receta->usuario_id != Yii::$app->user->id) {
            return $this->goHome();
        }
        $recetaId = $receta->id;
        $pasos = $receta->pasos;
        $nPasos = count($pasos);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($pasos as $paso) {
                if ($paso->delete() === false) {
                    throw new Exception();
                }
            }
            if ($receta->delete() === false) {
                throw new Exception();
            }
            $transaction->commit();

            Yii::$app->session->setFlash('success','La receta se ha borrado correctamente');
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger','Ha ocurrido un error al borrar la Receta');
        }

        $rutaReceta = Yii::$app->basePath . '/web/images/recetas/receta' . $recetaId . '.jpg';
        if (file_exists($rutaReceta)) {
            unlink($rutaReceta);
        }
        $rutaPaso = Yii::$app->basePath . '/web/images/pasos/paso-';
        for ($i = 0; $i < $nPasos; $i++) {
            $ruta = $rutaPaso . $recetaId . '-' . $i . '.jpg';
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        return $this->goHome();
    }

    /**
     * Finds the Recetas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recetas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recetas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
