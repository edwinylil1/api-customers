<?php

namespace App\Actions\System\users;

use App\Actions\Api\ApiResponse;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Clase para actualización de datos de usuario
 * @method update(User $user, array $input) metodo para actualizar usuario.
 * @method updateAccess(User $user, array $input) actualizar afiliación y grupo de usuario.
 * @method updateEmail(User $user, array $input) actualizar email.
 */
class UpdateUser
{

    /**
     * Recibe instancia del modelo User, segundo parametro contiene la data para actualizar.
     * Actualiza datos primarios de usuario.
     * @param User $user
     * @param array $input actualiza campos dni, name, country, state, address, telephone
     * @return mixed
     */
    public function update(User $user, array $input, bool $external = true)
    {
        if (!isset($input['dni']) && !isset($input['name']) && !isset($input['country']) && !isset($input['state']) && !isset($input['address']) && !isset($input['telephone'])) {
            return ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación');
        }
        try {
            $user->forceFill([
                'dni' => isset($input['dni']) ? $input['dni'] : $user->dni,
                'name' => isset($input['name']) ? $input['name'] : $user->name,
                'country' => isset($input['country']) ? $input['country'] : $user->country,
                'state' => isset($input['state']) ? $input['state'] : $user->state,
                'address' => isset($input['address']) ? $input['address'] : $user->address,
                'telephone' => isset($input['telephone']) ? $input['telephone'] : $user->telephone,
            ])->save();
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo actualizar el registro, intente nuevamente') : false;
        }
        return  $external ? ApiResponse::success(false, '', 204) : true;
    }

    /**
     * Recibe instancia del modelo User, segundo parametro contiene la data para actualizar.
     * Actualiza el email de usuario.
     * @param User $user
     * @param array $input
     * @return mixed
     */
    public function updateEmail(User $user, array $input, bool $external = true)
    {
        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            
                $this->updateVerifiedUser($user, $input);
            
        } else {

            $user->forceFill([
                'email' => $input['email'],
            ])->save();
            
            if ($user->wasChanged()) {
                return $external ? ApiResponse::success(false, 'email actualizado',204) : true;
            } else {
                return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
            }
            
        }
        
        return ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación');
    }

    /**
     * Actualizar roles de usuario.
     * @param Object $user usuario
     * @param mixed $input grupo de usuarios
     * @return mixed
     */
    public function updateUserRoles(User $user,array $input, bool $external = true)
    {
        if (isset($input['roles'])) {
            try {
                DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                $user->assignRole($input['roles']);
            } catch (\Throwable $th) {
                //throw $th;
                return $external ? ApiResponse::serverError('No se pudo procesar su cambio, intente nuevamente') : false;
            }
            return $external ? ApiResponse::success(false, '', 204) : true;
        } else {
            return ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación');
        }
    }


    /**
     * Update the given verified user's profile information.
     *
     * @param  User  $user
     * @param  array  $input
     * @return mixed
     */
    protected function updateVerifiedUser(User $user,array $input, bool $external = true)
    {
        $user->forceFill([
            'email_verified_at' => null,
            'email' => $input['email'],
        ])->save();

        if ($user->wasChanged()) {
            try {
                $user->sendEmailVerificationNotification();
            } catch (\Throwable $th) {
                //dd($th->getMessage());
                return $external ? ApiResponse::success(false, '',204) : true;
            }
            
            return $external ? ApiResponse::success(false, 'email actualizado',200) : true;
        }

        return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
    }

    /**
     * Actualizar contraseña
     *
     * @param  User  $user
     * @param  array  $input
     * @return mixed
     */
    public function updatePassword(User $user,array $input, bool $external = true)
    {
        try {
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();

            return $external ? ApiResponse::success(false, '',204) : true;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
        }
       
    }
}

?>