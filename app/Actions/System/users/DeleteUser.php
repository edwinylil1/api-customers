<?php

namespace App\Actions\System\users;

use App\Actions\Api\ApiResponse;
use App\Models\User;

class DeleteUser 
{
    /**
     * Delete the given user,
     * Borrado lógico del usuario,
     * Elimina los tokens de acceso.
     */
    public function delete(User $user, bool $external = true)
    {
        try {
            $user->tokens()->delete();
            $user->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo eliminar el registro, intente nuevamente') : false;
        }
        return $external ? ApiResponse::success(false, '', 204) : true;
    }
}
