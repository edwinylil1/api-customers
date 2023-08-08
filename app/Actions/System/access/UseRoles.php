<?php

namespace App\Actions\System\access;

use App\Actions\Api\ApiResponse;
use App\Http\Traits\Forms\FormsTrait;
use App\System\ApiCustomers;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

/**
 * Métodos para administrar roles.
 * @method createRol($input) método para crear el grupo de usuarios.
 * @method getRoles($paginate) Obtiene todos los grupos de usuarios para el método index.
 * @method pluckRoles() Retorna todos los roles con el metodo all.
 * @method userRoles() Retorna los roles a partir del rol del usuario actual.
 * @method getRole($id) busca el grupo.
 * @method getRoleAndPermissions($id) obtiene el grupo con los permisos.
 * @method updateRole($role, $input) actualiza la información del grupo de usuarios y sus permisos.
 * @method deleteRole(Role $role) Recibe como parámetro el objeto a eliminar.
 */
class UseRoles
{
    use FormsTrait;
    
    /**
     * Crea un nuevo grupo de usuarios
     * @param array $input contiene los valores para crear el rol
     * @param bool $external de ser true retorna respuesta json en false el true de ser creado
     * @return mixed respuesta json con el recurso - recurso o false
     */
    public function createRol(array $input, bool $external = true)
    {
        try {
            $role = Role::create(
                [
                    'name' => $input['name'], 
                    'guard_name' => isset($input['guard_name']) ? $input['guard_name'] : 'web', 
                    'description' => isset($input['description']) ? $input['description'] : ''
                ]
            );
            return $external ? ApiResponse::success($role, 'Grupo creado') : $role;
        } catch (\Throwable $th) {
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
    }


    /**
     * Métodos para obtener todos los roles.
     */

    /**
    * Retorna los roles (grupos) de usuarios del paquete Spatie
    * @param array $input ['paginate'] entero sin signo que establece el límite la paginación
    * @param bool $external de ser true retorna respuesta json en false el true de ser creado
    * @return mixed retorna json con los roles paginados o solo el recurso
    **/
    public function getRoles(array $input, bool $external = true)
    {
        $paginate = isset($input['pagination']) ? $input['pagination'] : ApiCustomers::defaultPagination();

        try {
            $roles = Role::orderBY('id','Desc')->paginate($paginate);
            return $external ? ApiResponse::success($roles, 'Listado páginado de los grupos de usuarios') : $roles;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
    }
    
    /**
     * Retorna todos los roles para asignar a un usuario
     * @param bool $external de ser true retorna respuesta json en false el recurso
     * @return mixed json con los todos los roles sin paginar o el recurso
     */
    public function pluckRoles(bool $external = true)
    {
        try {
            $roles = Role::pluck('name','name')->all();
            return $external ? ApiResponse::success($roles, 'Listado de grupos disponibles') : $roles;
        } catch (\Throwable $th) {
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }

    }
    
    /**
     * Retorna los roles filtrados para administración de usuarios
     * @param bool $external de ser true retorna respuesta json en false el recurso
     * @return mixed json con el grupo de usuario autenticado en adelante o el recurso
     */
    public function userRoles(bool $external = true)
    {
        try {
            $roles = [];
            $user = Auth::user();
            $role = $user->getRoleNames();
            $id = $role[0];
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }

        if (isset($id)) {
            try {
                $filter_roles = Role::select('name')->where('id','>=',Role::pluck('id','name')->get($id))->get();

                foreach ($filter_roles as $key => $value) {
                    array_push($roles, $value->name);
                }

                return $external ? ApiResponse::success($roles, 'grupos de usuarios disponibles') : $roles;
            } catch (\Throwable $th) {
                //throw $th;
                return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
            }
        }
    }

    /**
     * Obtiene el grupo de usuarios a consultar
     */

    /**
     * @param int $id entero sin signo, id del grupo
     * @param bool $external de ser true retorna respuesta json en false el recurso
     * @return mixed json con rol encontrado o el recurso
     */
    public function getRole(int $id, bool $external = true) : mixed
    {
        try {
            $role = Role::find($id);
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
        
        if (isset($role->id)) {
            return $external ? ApiResponse::success($role, 'grupo de usuario encontrado') : $role;
        }
        
        return $external ? ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404) : false;
    }

    /**
     * Recupera el nombre de los permisos asignados a un grupo de usuario.
     * @param object $role instancia del modelo role
     * @param bool $external de ser true retorna respuesta json en false el recurso
     * @return mixed json con rol encontrado o el recurso
     */
    public function getRoleAndPermissions(Role $role, bool $external = true)
    {
        $permission = [];
        try {
            $input =  $role->permissions->pluck('name');

            foreach ($input as $key => $value) {
                array_push($permission, $value);
            }

            return $external ? ApiResponse::success($permission, 'Listado de permsisos') : $permission;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
        
        return $external ? ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404) : false;
    }

    /**
     * actualizar el grupo de usuarios y los permisos.
     * @param object $role instancia del modelo role
     * @param object $input el request
     * @param bool $external de ser true retorna respuesta json en false bool
     * @return mixed json con la respuesta o bool
     */
    public function updateRole(Role $role, array $input, bool $external = true) 
    {
        if (!isset($input['name']) && !isset($input['description']) && !isset($input['guard_name']) && !isset($input['permissions'])) {
            return $external ? ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación') : false;
        }
        try {
            $role->name = isset($input['name']) ? $input['name'] : $role->name;
            $role->description = isset($input['description']) ? $input['description'] : $role->description;
            $role->guard_name = isset($input['guard_name']) ? $input['guard_name'] : $role->guard_name;
            $role->save();
            
            if (isset($input['permissions'])) {
                $role->syncPermissions($input['permissions']);
            }
        } catch (\Throwable $th) {
            return $external ? ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde') : false;
        }
        return  $external ? ApiResponse::success(false, '', 204) : true;
    }


    /**
     * Eliminar un grupo de usuarios.
     */

    /**
     * Recibe el objeto role para eliminar.
     * @param object $role objeto role
     * @param bool $external de ser true retorna respuesta json en false el recurso
     * @return mixed json con la respuesta o bool
     */
    public function deleteRole(Role $role, bool $external = true)
    {
        try {
            $role->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo eliminar el registro, intente nuevamente') : false;
        }
        return $external ? ApiResponse::success(false, '', 204) : true;
    }
}

?>