<?php

namespace Database\Seeders;

use App\Actions\System\access\UsePermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(UsePermissions $use_permissions): void
    {
        // permisos para manipular los grupos de usuario
        $permisos = [
            [
                'name' => 'roles.index', 
                'description' => 'listar los grupos de usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'roles.store', 
                'description' => 'crear un grupo de usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'roles.show', 
                'description' => 'ver un grupo de usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'roles.destroy', 
                'description' => 'eliminar los grupos de usuarios', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'roles.update', 
                'description' => 'editar los grupos de usuarios', 
                'guard_name' => 'api
                ']
        ];
        $use_permissions->createPermissions($permisos, false);

        // permisos para administración de usuarios
        $permisos = [
            [
                'name' => 'users.index', 
                'description' => 'listar los usuarios de usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users.store', 
                'description' => 'crear usuarios', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users.show', 
                'description' => 'mostrar usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users.destroy', 
                'description' => 'eliminar usuarios', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users.update', 
                'description' => 'editar un usuarios', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users-email.update', 
                'description' => 'editar email de usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users-password.update', 
                'description' => 'cambiar contraseña de usuario', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users-access.token', 
                'description' => 'generar API key token', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'users-access.update', 
                'description' => 'cambiar nivel de acceso del usuario', 
                'guard_name' => 'web'
            ]
        ];
        $use_permissions->createPermissions($permisos, false);


        // Permisos para el mantenimiento de clientes en pedidos
        $permisos = [
            [
                'name' => 'client.index', 
                'description' => 'Listar los clientes de pedidos del API', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client.store', 
                'description' => 'Crear un nuevo cliente de pedidos en el API', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client.show', 
                'description' => 'Ver un cliente de pedidos en el API  (no editable)', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client.destroy', 
                'description' => 'Eliminar un cliente de pedidos del API, (permite eliminar solo si no está sincronizado)', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client.update', 
                'description' => 'editar un cliente de pedidos en el API, (permite editar solo si no está sincronizado)', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client-transfer.store', 
                'description' => 'transferir un cliente de orbisnet al API', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client-transfer.update', 
                'description' => 'Editar un cliente de pedidos del API, (sin restricción de estado, solo para comsisa)', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client-transfer.destroy', 
                'description' => 'Eliminar un cliente de pedidos del API, (sin restricción de estado, solo para comsisa)', 
                'guard_name' => 'web'
            ],
            [
                'name' => 'client-status.update', 
                'description' => 'Cambiar el valor de api_status por valores lista del cliente', 
                'guard_name' => 'web'
            ]
        ];
        $use_permissions->createPermissions($permisos, false);

        
        unset($permisos);
        unset($use_permissions);
    }
}
