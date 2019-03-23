<?php

namespace app\controllers;

use app\models\Etiquetas;
use yii\web\Controller;
use yii\db\Query;

/**
 * EtiquetasController implements the CRUD actions for Etiquetas model.
 */
class EtiquetasController extends Controller
{
    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('nombre AS id, nombre AS text')
                ->from('etiquetas')
                ->where(['ilike', 'nombre', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Etiquetas::find($id)->nombre];
        }
        return $out;
    }
}
