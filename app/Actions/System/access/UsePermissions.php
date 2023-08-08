<?php

namespace App\Actions\System\access;

use App\Actions\Api\ApiResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Manipulación de permisos.
 * @method createPermissions(array input) metodo para crear los permisos
 * @method getPermissions() método para obtener todos los permisos del sistema
 * @method getPermissionsName($permissions, $filter) metodo creado para filtrar los permisos del sistema por la puerta de acceso y retornar un array con los nombres
 * @method assignPermissions($role, $input) recibe una instancia del modelo role y un array con el indice permissions con el valor del permiso a asignar
 */
class UsePermissions
{
    
    /**
     * Crea los permisos para el paquete Spatie
     * @param array $input recibe un array con todos los nombres de los permisos
     * @return mixed true o status 204
     */
    public function createPermissions(array $input, bool $external = true)
    {
        foreach ($input as $permiso) {
            try {
                $search = DB::select('select name from permissions where name = ?', [$permiso['name']]);

                if (!$search) {
                    try {
                        Permission::create(
                            [
                                'name' => $permiso['name'], 
                                'description' => $permiso['description']
                            ]
                        );
                    } catch (\Throwable $th) {
                        //throw $th;
                        return $external ? ApiResponse::serverError("no se pudo conectar al servidor, quedo en: ". $permiso['name'] . ", intente mas tarde") : false;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
            }
        }

        return $external ? ApiResponse::success(false, '', 204) : true;
    }

    /**
     * Obtiene los permisos que se puede aplicar a los grupos de usuarios
     * @return object all permission
     */
    public function getPermissions(bool $external = true)
    {
        try {
            $permissions = Permission::get();

            return $external ? ApiResponse::success($permissions, 'Listado de todos los permisos') : $permissions;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
    }

    /**
     * Obtiene los nombres de todos los permisos para iterar en un array
     * @param object $permissions todos los permisos delsistema
     * @param string $filter puerta de acceso del permiso
     */
    public function getPermissionsByGuard($permissions, string $filter, bool $external = true)
    {
        $permission = ['permissions' => []];

        try {
            $permissions = $permissions->where('guard_name', $filter);

            foreach ($permissions as $key => $value) {
                array_push($permission['permissions'], $value->name);
            }

            return $external ? ApiResponse::success($permission, 'Listado de todos los permisos') : $permission;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
        
        return $external ? ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación') : false;
    }

    /**
     * Recibe una instancia del modelo Role y los permisos a aplicar en un array o collección
     * @return mixed
     */
    public function assignPermissions(Role $role, $input, bool $external = true)
    {
        try {
            $role->syncPermissions($input['permissions']);
            return $external ? ApiResponse::success(false, '', 204) : true;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación') : false;
        }
        
    }
}

?>