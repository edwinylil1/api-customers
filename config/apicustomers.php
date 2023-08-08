<?php
/**
 * Parametros de Configuración para las rutas del sistema
 */

    return[
        // control de mantenimiento para usuarios del sistema
        'user_maintenance' => env('USERMAINTENANCE', true),
        // grupos de usuarios
        'permissions' => env('USERGROUPS', true),
        // maestro de clientes web
        'customer_master' => env('CUSTOMERMASTER', true),
        
        // cantidad minima del páginado de registros
        'default_pagination' => env('DEFAULTPAGINATION', 20),
        // cantidad minima del páginado de registros
        'time_in_hours_cache' => env('TIMEINHOURSCACHE', 24),
    ];