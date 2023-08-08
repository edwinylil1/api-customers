<?php

namespace App\Http\Traits\Forms;

/**
 * Trait con metodos para los trabajos con string.
 * Métodos:
 *  * sanitizeString
 *  * htmlspecialchars
 *  * extractString
 */
trait StringTrait
{
    /**
     * Devuelve una cadena limpia para guardar en la base de datos
     * Se emplea en los datos que vengan del request,
     * emplea htmlentities(strip_tags($string)).
     * @param string valor a limpiar
     * @return string valor seguro para guardar en la base de datos
     */
    public function sanitizeString(string $string) : string
    {
        $string = htmlentities(strip_tags($string));

        return $string;
    }

    /**
     * Devuelve un string para mostrar en el front
     * Función empleada para limpiar la información almacenada en la base de datos 
     * ya introducida por el usuario.
     * @param string $string valor recuperado de la base de datos
     * @return string convierte los caracteres especiales que encuentre en entidades html
     */
    public function getCleanString(string $string) : string
    {
        $string = htmlspecialchars($string);
        return $string;
    }

    /**
     * Metodo creado para manipular los string, elimina un string de la cadena enviada, por defecto elimina los 
     * "-" en la cadena, si el segundo parametro es true, devuelve el primer caracter en mayúsculas
     * @param string $input string a limpiar
     * @param bool $ucfirst si esta en true, devuelve una cadena con el primer caracter en 
     * mayúsculas, si el carácter es alfabético 
     * @param string $search valor a eliminar, por defecto un "-"
     * @param string $replace valor que se aplicara para el reemplazo, por defecto, vacio
     */
    public function extractString(string $input, bool $ucfirst = false, string $search = '-', string $replace = '') : string
    {   
        $value = str_replace($search, $replace, $input);
        return $ucfirst ? ucfirst($value) : $value;
    }
}
?>