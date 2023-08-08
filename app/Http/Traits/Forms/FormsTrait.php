<?php

namespace App\Http\Traits\Forms;

/**
 * Trait que contiene casos de uso de procesos en campos de formulario.
 * @method getPaginated(int $value = 5) : int
 * @method getPaginatedResource(array $columns, $data, array $filters = []) : array
 * @method searchMin($string)
 **/
trait FormsTrait
{
    /**
     * Empleado para la paginación, retorna la cantidad mínima de resultados por página
     * @param int $value valor mínimo de paginación, es 5
     * @return int entero de paginación
     */
    public function getPaginated(int $value = 5) : int
    {
        switch ($value) {
            case null:
                case 0:
                    case 1:
                        case 2:
                            case 3:
                                case 4:
                                    case 5:
                return 5;
                break;
            
            default:
            return $value;
                break;
        }
    }

    /**
     * Crea un recurso páginado con los valores necesarios para facilitar su interpretación en
     * el front
     * @param array $columns nombre de columnas para visualizar
     * @param mixed $data recurso
     * @param array $filters que pueden aplicar, se puede omitir
     * @return array registro páginado con opciones aplicadas
     */
    public Function getPaginatedResource(array $columns, $data, array $filters = []) : array
    {
        return [
            'values'    =>
                [
                    'columns'   => $columns
                ],                
            'resource' => $data,
            'filters'   => $filters,
        ];
    }

    /**
     * Creado para determinar cual es la cantidad minima de carácteres 
     * que se deben emplear para tener un string válido para búsquedas 
     */
    public function searchMin($string) : mixed
    {
        $string = strlen($string) >= 4 ? $string : null;

        return $string;
    }

    /**
     * Validate that the total of all amount fields in the detail
     * matches the total specified amount /
     * Validar que el total de todos los campos de cantidad en el detalle
     * coincide con la cantidad total especificada.
     * @param array $input Array of details 
     * @param $value_foreign The total supposed amount / La cantidad total supuesta
     * @param string $field Name of the amount field in each detail (default 'value_foreign') / Nombre del campo de cantidad en cada detalle (predeterminado 'value_foreign')
     * @return bool True if totals match, false otherwise / Verdadero si los totales coinciden, falso en caso contrario
     */
    public function validateTotalAmountsAgainstDetail(array $input, $value_foreign, string $field = 'value_foreign') : bool
    {
        $full_value_of_products = 0;

        foreach ($input as $key) {
            $full_value_of_products += $key[$field];
        }

        if ($full_value_of_products == $value_foreign) {
            return true;
        }

        return false;
    }
}
?>