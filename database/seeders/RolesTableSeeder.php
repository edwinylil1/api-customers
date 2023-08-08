<?php

namespace Database\Seeders;

use App\Actions\System\access\UsePermissions;
use App\Actions\System\access\UseRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;

class RolesTableSeeder extends Seeder
{
    protected $clients;
    protected $clients_store;

    public function __construct()
    {
        $this->clients_store = [
            'permissions' => [
                'client.index',
                'client-transfer.store',
                'client.show',
                'client-transfer.update',
                'client-transfer.destroy'
            ]
        ];
         /**
          * final de permisos para tienda
          */

        /**
         * Permisos de clientes para clientes en pedidos
         */
        $this->clients = [
            'permissions' => [
                'client.index',
                'client.store',
                'client.show',
                'client.update',
                'client.destroy',
                'client-status.update'
            ]
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(UseRoles $use_roles, UsePermissions $use_permissions): void
    {
        $new_role = [
            'name' => 'admin',
            'guard_name' => 'web',
            'description' => 'Grupo admin, usualmente posee acceso full'
        ];

        if($this->verifyRole($new_role)){
            $role = $use_roles->createRol($new_role, false);
            $permissions = $use_permissions->getPermissionsByGuard($use_permissions->getPermissions(false), 'web', false);
            $use_permissions->assignPermissions($role, $permissions, false);
        }

        $new_role = [
            'name' => 'cliente',
            'guard_name' => 'web',
            'description' => 'Grupo generico del sistema cliente, posee opciones básicas de acceso (usuario para la web externa).'
        ];
        
        if($this->verifyRole($new_role)){
            $role = $use_roles->createRol($new_role, false);
            $permissions = array_merge_recursive($this->clients);
            $use_permissions->assignPermissions($role, $permissions, false);
        }

        $new_role = [
            'name' => 'tienda',
            'guard_name' => 'web',
            'description' => 'Grupo de usuario para el sistema del cliente en tienda, posee opciones específicas de acceso.'
        ];
        
        if($this->verifyRole($new_role)){
            $role = $use_roles->createRol($new_role, false);
            $permissions = array_merge_recursive($this->clients_store);
            $use_permissions->assignPermissions($role, $permissions, false);
        }
    }

    /**
     * Verifica que no exista el rol a crear
     * @param $input propiedades del rol 
     * @return bool
     */
    private function verifyRole(array $input): bool
    {
        $val = Validator::make($input, [
            'name' => ['required','string','min:3','max:100','unique:roles'],
            'guard_name' => ['required','string','min:3','max:255'],
            'description' => ['nullable','string','max:255'],
        ]);

        return $val->fails() ? false : true;
    }
}
