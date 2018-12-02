<?php

namespace app\controllers;

use Yii;
use app\models\Recetas;
use app\models\Categorias;
use app\models\Pasos;
use app\models\RecetasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
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
        $searchModel = new RecetasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
                $newPasos = new Pasos();
                $newPasos->texto = $data;
                $pasosArray[$i] = $newPasos;
            }
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $valid = $recetas->validate();
                $valid = Model::validateMultiple($pasosArray, ['texto']) && $valid;
                if ($valid) {
                    $recetas->fotoPrincipal = UploadedFile::getInstance($recetas, 'fotoPrincipal');
                    $recetas->save(false);
                    foreach ($pasosArray as $newPasos) {
                        $newPasos->receta_id = $recetas->id;
                        $newPasos->save(false);
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

        if ($recetas->load(Yii::$app->request->post())) {
            $recetas->fotoPrincipal = UploadedFile::getInstance($recetas, 'fotoPrincipal');
            if ($recetas->save() && $recetas->upload()) {
                $arrayPasos = Yii::$app->request->post('Pasos');
                foreach ($arrayPasos as $paso) {
                    $pasos = new Pasos();
                    $pasos->texto = $paso;
                    $pasos->receta_id = $recetas->id;
                    $pasos->save();
                }
                return $this->redirect(['view', 'id' => $recetas->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
