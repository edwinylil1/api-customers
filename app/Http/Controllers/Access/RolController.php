<?php

namespace App\Http\Controllers\Access;

use App\Actions\Api\ApiResponse;
use App\Actions\System\access\UsePermissions;
use App\Actions\System\access\UseRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Access\roles\CreateRoleRules;
use App\Http\Requests\Access\roles\SearchRoleRules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolController extends Controller
{
    /**
     * middleware para el control de acceso
     */
    function __construct()
    {
        $this->middleware('permission:roles.index|roles.create|roles.show|roles.edit|roles.destroy' , [
            'only' => ['index']
            ]
        );
        $this->middleware('permission:roles.store' , [
            'only' => ['create', 'store']
            ]
        );
        $this->middleware('permission:roles.show' , [
            'only' => ['show']
            ]
        );
        $this->middleware('permission:roles.update' , [
            'only' => ['edit', 'update']
            ]
        );
        $this->middleware('permission:roles.destroy' , [
            'only' => ['destroy']
            ]
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRoleRules $request, UseRoles $use_roles) : JsonResponse
    {
        return $use_roles->getRoles($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(UsePermissions $use_permissions) : JsonResponse
    {
        return ApiResponse::success(
            [
                'required' => 'name, permissions (array) con id de permsisos',
                'optional' => 'description', 
                'all_permisions' => $use_permissions->getPermissions(false)
            ],'información para crear un nuevo grupo de usuarios');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRules $request, UseRoles $use_roles, UsePermissions $use_permissions) : JsonResponse
    {
        $role = $use_roles->createRol($request->all(), false);
        if ($role) {
            $assign_permissions = $use_permissions->assignPermissions($role, $request->all(), false);
            return $assign_permissions ? ApiResponse::success($role, 'grupo creado') : ApiResponse::success($role, 'se creo el grupo ' . $role->name .' pero no se pudieron guardar los permisos de acceso, edite su grupo id ' . $role->id . 'para establecer los permisos');
        } else {
            return ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, UseRoles $use_roles) : JsonResponse
    {   
        if($this->validateRole($id))
        {
            return ApiResponse::clientError('id del grupo incorrecto');
        }

        $role = $use_roles->getRole($id, false);
        $permissions = $use_roles->getRoleAndPermissions($role, false) ? $use_roles->getRoleAndPermissions($role, false) : 'sin permisos establecidos';
        
        
        return $role ? ApiResponse::success(['grupo' => $role, 'permission_summary' => $permissions], 'Grupo de usuarios con sus permisos') : ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, UseRoles $use_roles, UsePermissions $use_permissions) : JsonResponse
    {
        if($this->validateRole($id))
        {
            return ApiResponse::clientError('id del grupo incorrecto');
        }

        $role = $use_roles->getRole($id, false);
        $role_permissions = $use_roles->getRoleAndPermissions($role, false) ? $use_roles->getRoleAndPermissions($role, false) : 'sin permisos establecidos';
        $permissions = $use_permissions->getPermissions(false);
        
        
        return $role ? ApiResponse::success([
                'group' => $role, 
                'permission_summary' => $role_permissions,
                'all_permissions' => $permissions
            ], 'Grupo de usuarios con sus permisos y listado de todos los permisos disponibles') : ApiResponse::serverError('no se pudo conectar al servidor, intente mas tarde');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id, UseRoles $use_roles) : JsonResponse
    {
        if($this->validateRole($id))
        {
            return ApiResponse::clientError('id del grupo incorrecto');
        }
        
        $validate = $this->validateUpdateRole($request->all(), $id);
        if ($validate) {
            return ApiResponse::clientError(['message' => 'error en solicitud.', 'errors' => $validate], 422);
        }

        $role = $use_roles->getRole($id, false);
        
        return $role ? $use_roles->updateRole($role, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, UseRoles $use_roles) : JsonResponse
    {
        if($this->validateRole($id))
        {
            return ApiResponse::clientError('id del grupo incorrecto');
        }

        $role = $use_roles->getRole($id, false);
        
        return $role ? $use_roles->deleteRole($role) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    private function validateRole($id)
    {
        $val = Validator::make(['role' => $id], [
            'role' => ['required','integer','min:1', Rule::exists('roles', 'id')],
        ]);

        return $val->fails();
    }

    private function validateUpdateRole(array $input, int $id)
    {
        $val = Validator::make($input, [
            'name' => ['nullable','string','min:3','max:100', Rule::unique('roles')->ignore($id)],
            'permissions' => ['nullable','array'],
            'permissions.*' => 'nullable|integer|min:1|'. Rule::exists('permissions', 'id'),
            'description' => ['nullable','string','max:255'],
            'guard_name' => ['nullable','string','min:3','max:255', Rule::in(['web','api'])]
        ]);
        
        return $val->fails() ? $val->errors() : false;
    }
}
