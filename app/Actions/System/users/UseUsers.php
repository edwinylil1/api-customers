<?php

namespace App\Actions\System\users;

use App\Actions\Api\ApiResponse;
use App\Http\Traits\Forms\FormsTrait;
use App\Models\User;
use App\System\ApiCustomers;
use Illuminate\Support\Facades\DB;

/**
 * Metodos para obtener información de usuario.
 * @method getUsers($paginate, $search) Obtiene todos los usuarios del sistema, con su grupo de acceso paginados con un mínimo de 5 usuarios por página
 * @method getUser(key $user) busca el usuario por la clave de usuario del modelo
 * @method getUserRoles(User $user) Retorna los roles del usuario registrado
 * @method getUserByField($user,$column) busca el usuario por el campo pasado
 */
class UseUsers
{
    use FormsTrait;

    /**
     * Retorna los usuarios paginados, agregando los roles de usuario
     * @param int $input array con parámetros de búsqueda
     * @param string $external si va a generar respuesta json
     * @return mixed json con respuesta - lista de usuarios - false
     */
    public function getUsers(array $input, bool $external = true)
    {
        $name = isset($input['name']) ? $input['name'] : '';
        $email = isset($input['email']) ? $input['email'] : '';
        $user_id = isset($input['user-id']) ? $input['user-id'] : '';
        $paginate = isset($input['paginate']) ? $input['paginate'] : ApiCustomers::defaultPagination();

        try {
            $users =  User::orderBY('id','Desc')
                ->with('roles')
                ->name($name)
                ->email($email)
                ->userId($user_id)
                ->paginate($paginate)
                ->appends(request()->all());

            return  $external ? ApiResponse::success($users) : $users;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('error del servidor, intente mas tarde') : false;
        }
    }

    /**
     * Busca el usuario en la base de datos, si no lo consigue retorna falso
     * @param mixed $user campo de búsqueda para el usuario, dictado por el modelo
     * @return Object user or false
     */
    public function getUser(int $user, bool $external = true)
    {
        try {
            $user = User::with('roles')->find($user);
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
        }
        
        if (isset($user->id)) {
            try {
                $data = $user;
            } catch (\Throwable $th) {
                //throw $th;
                return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
            }

            return $external ? ApiResponse::success($data) : $data;
        }
        return $external ? ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404) : false;
    }

    /**
     * Retorna los roles del usuario registrado
     * @param mixed $user Objeto usuario
     * @return object roles de usuario
     */
    public function getUserRoles(User $user, bool $external = true)
    {
        return $external ? ApiResponse::success($user->getRoleNames()) : $user->getRoleNames();
    }

    /**
     * Busca el usuario en la base de datos, si no lo consigue retorna falso.
     * @param string $user valor a buscar
     * @param string $column columna por la cual buscar, por defecto es email
     * @return Object user or false
     */
    public function getUserByField(string $user, string $column = 'email', bool $external = true)
    {
        if (DB::table('users')->where($column, $user)->exist()) {
            try {
                $data = User::select('id', 'user_id', 'email', 'name')->where($column, $user)->with('roles')->first();
            } catch (\Throwable $th) {
                return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
            }
            return $external ? ApiResponse::success($data) : $data;
        }
        return $external ? ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404) : false;
    }
}

?>