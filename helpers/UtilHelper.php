<?php

namespace app\helpers;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * Clase Helper
 */
class UtilHelper
{
    /**
     * Crea una array cuya clave es el id del modelo y el valor el nombre
     * @param  mixed $modelos El modelo
     * @return array          El array con el id y el nombre
     */
    public static function getDropDownList($modelos)
    {
        $s = ArrayHelper::toArray($modelos);
        $a = ArrayHelper::getColumn($s, 'id');
        $b = ArrayHelper::getColumn($s, 'nombre');
        return array_combine($a, $b);
    }

    /**
     * Crea un icono de Bootstrap.
     * @param  string $icon   Nombre del icono de Bootstrap
     * @param  array $options Array de opciones del icono
     * @return string         La etiqueta span con el icono de Bootstrap.
     */
    public static function glyphicon(string $icon, array $options = [])
    {
        if (isset($options['class'])) {
            $options ['class'] .= " glyphicon glyphicon-$icon";
        } else {
            $options ['class'] = "glyphicon glyphicon-$icon";
        }
        return Html::tag(
            'span',
            '',
            $options
        );
    }

    /**
     * Devuelve un template para colocar un icono de Bootstrap en un campo
     * de ActiveForm.
     * @param  string $glyphicon Nombre del icono de Bootstrap
     * @return string            La cadena del template
     */
    public static function inputGlyphicon($glyphicon)
    {
        return '<div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-' . $glyphicon . '"></span>
                    </span>
                    {input}
               </div>';
    }
}
