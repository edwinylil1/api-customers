<?php

namespace App\Http\Controllers\Access;

use App\Actions\Api\ApiResponse;
use App\Actions\System\users\CreateNewUser;
use App\Actions\System\users\DeleteUser;
use App\Actions\System\users\UpdateUser;
use App\Actions\System\users\UseUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Access\Scope\SearchUserRules;
use App\Http\Requests\Access\users\CreateNewUserRules;
use App\Http\Requests\Access\users\UpdateAccessRules;
use App\Http\Requests\Access\users\UpdateEmailRules;
use App\Http\Requests\Access\users\UpdatePasswordRules;
use App\Http\Requests\Access\users\UpdateUserRules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GeneralUserController extends Controller
{
    /**
     * middleware para el control de acceso
     */
    public function __construct()
    {
        $this->middleware('permission:users.index|users.store|users.show|users.update|users.destroy' , [
            'only' => ['index']
            ]
        );
        $this->middleware('permission:users.store' , [
            'only' => ['store']
            ]
        );
        $this->middleware('permission:users.show' , [
            'only' => ['show']
            ]
        );
        $this->middleware('permission:users.update' , [
            'only' => ['update']
            ]
        );
        $this->middleware('permission:users.destroy' , [
            'only' => ['destroy']
            ]
        );
        $this->middleware('permission:users-email.update' , [
            'only' => ['updateEmail']
            ]
        );
        $this->middleware('permission:users-password.update' , [
            'only' => ['updatePassword']
            ]
        );
        $this->middleware('permission:users-access.token' , [
            'only' => ['generateApiKey']
            ]
        );
        $this->middleware('permission:users-access.update' , [
            'only' => ['updateAccess']
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchUserRules $request, UseUsers $use_users) : JsonResponse
    {
        return $use_users->getUsers($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewUserRules $request,  CreateNewUser $new_user) : JsonResponse
    {
        return $new_user->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id, UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        return $use_users->getUser($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRules $request, $id, UpdateUser $update_user, UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $user = $use_users->getUser($id, false);

        return $user ? $update_user->update($user, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, DeleteUser $delete_user, UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $user = $use_users->getUser($id, false);

        return $user ? $delete_user->delete($user) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Cambiar email
     */
    public function updateEmail(UpdateEmailRules $request, $id, UpdateUser $update_user, UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $user = $use_users->getUser($id, false);

        return $user ? $update_user->updateEmail($user, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Cambiar contraseña
     */
    public function updatePassword(UpdatePasswordRules $request, $id, UpdateUser $update_user,UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $user = $use_users->getUser($id, false);

        return $user ? $update_user->updatePassword($user, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Generar una nueva clave de aplicación
     */
    public function generateApiKey($id, CreateNewUser $create_token, UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $user = $use_users->getUser($id, false);
        return $user ? $create_token->generateApiKey($user) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Cambiar contraseña
     */
    public function updateAccess(UpdateAccessRules $request, $id, UpdateUser $update_user, UseUsers $use_users) : JsonResponse
    {
        if($this->validateUser($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $user = $use_users->getUser($id, false);
        return $user ? $update_user->updateUserRoles($user, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    private function validateUser($id)
    {
        $val = Validator::make(['user' => $id], [
            'user' => ['required','integer','min:1', Rule::exists('users', 'id')],
        ]);
        
        return $val->fails();
    }
}
