<?php

namespace App\System;

use App\Jobs\ProcessUpdateStatus;

/**
 * Clase que retorna valores de activación para funcionalidades del portal activo
 */
class ApiCustomers
{
    /**
     * Indica si se activan las rutas para crear, editar y eliminar usuarios del sistema
     */
    public static function userMaintenanceConfig() : bool
    {
        return config('apicustomers.user_maintenance');
    }

    /**
     * Indica si se activan las rutas para crear, editar y eliminar los grupos y permisos de usuarios
     * Los permisos se pueden activar o desactivar a un grupo, no tienen escritura.
     */
    public static function permissionsConfig() : bool
    {
        return config('apicustomers.permissions');
    }
    
    /**
     * Indica si se activan las rutas para crear, editar y eliminar clientes
     */
    public static function customerMasterConfig() : bool
    {
        return config('apicustomers.customer_master');
    }
    
    /**
     * Devuelve la cantidad de registros a páginar por defecto
     */
    public static function defaultPagination() : int
    {
        return config('apicustomers.default_pagination');
    }

    /**
     * Devuelve la cantidad de horas en cache
     */
    public static function timeInHoursCache() : int
    {
        return config('apicustomers.time_in_hours_cache');
    }

    /**
     * Devuelve la valores posibles de api_status para clientes
     * a la fecha 2023-07-25, todos los posibles para el cliente son: 7
     */
    public static function apiStatusClientValues() : array
    {
        return [7];
    }

    /**
     * Devuelve la valores posibles de api_status
     * a la fecha 2023-07-25, todos los posibles son: 1,2,10,20,4,5,40,50,7
     */
    public static function apiStatusValues() : array
    {
        return [1,2,10,20,4,5,40,50,7];
    }

    /**
     * Devuelve la valores posibles de api_status que permiten modificar el estado a un cliente
     * a la fecha 2023-07-26, todos los posibles son: 4,5
     */
    public static function apiStatusUpdateValues() : array
    {
        return [4,5];
    }

    /**
     * Devuelve la valores posibles de api_status que permiten modificar el estado a un cliente
     * a la fecha 2023-07-26, todos los posibles son: 10,4,5
     */
    public static function apiStatusUpdateValuesTwo() : array
    {
        return [10,4,5];
    }

    /**
     * Devuelve la valores posibles de api_status que permiten sincronizar el estado a un cliente
     * a la fecha 2023-07-26, todos los posibles son: 10,20
     */
    public static function apiStatusSync() : array
    {
        return [10,20];
    }

    /**
     * Devuelve la valores posibles de api_status que permiten eliminar un recurso a un cliente
     * a la fecha 2023-07-25, todos los posibles son: 4
     */
    public static function apiStatusDeleteValues() : array
    {
        return [4];
    }


    /**
     * Devuelve los valores lista que indican que el estado debe ser actualizado
     * a la fecha 2023-08-01, todos los posibles son: 1,2,4,5
     */
    public static function apiStatusToUpdate() : array
    {
        return [1,2,4,5];
    }

    /**
     * Devuelve los valores lista que indican que el recurso no a sido visto por el cliente
     * a la fecha 2023-08-01, todos los posibles son: 1,2
     */
    public static function apiStatusPending() : array
    {
        return [1,2];
    }

    /**
     * Enviar trabajo de cambio de estado.
     * @param string $table nombre de la tabla para actualizar el estado del recurso
     * @param string $api_status valor actual de api_status
     * @param string $column nombre de la columna clave para el where
     * @param string $id_column valor de la columna clave para el where
     * @param string $delete_key valor a borrar de la cache si existe
     * @return void
     */
    public static function sendStatus(string $table, string $api_status, string $column, string $id_column, string $delete_key) : void
    {
        ProcessUpdateStatus::dispatch($table, $api_status, $column, $id_column, $delete_key);
    }
}

?>