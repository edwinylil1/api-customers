<?php

namespace App\Http\Controllers\Clients;

use App\Actions\Api\ApiResponse;
use App\Actions\Clients\CreateNewClient;
use App\Actions\Clients\DeleteClient;
use App\Actions\Clients\UpdateClient;
use App\Actions\Clients\UseClients;
use App\Actions\System\cache\UseCache;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\CreateNewClientRules;
use App\Http\Requests\Clients\Scope\SearchClientRules;
use App\Http\Requests\Clients\TransferClientRules;
use App\Http\Requests\Inventory\products\StatusUpdateRules;
use App\Rules\CustomApiStatusValues;
use App\Rules\CustomBasicCharacterFormat;
use App\Rules\CustomCurrencyFormat;
use App\Rules\CustomPhoneFormat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * middleware para el control de acceso
     */
    function __construct()
    {
        $this->middleware('permission:client.index|client.store|client.show|client.update|client.destroy|client-transfer.store|client-transfer.update|client-transfer.destroy' , [
            'only' => ['index']
            ]
        );
        $this->middleware('permission:client.store|client-transfer.store' , [
            'only' => ['store']
            ]
        );
        $this->middleware('permission:client.show' , [
            'only' => ['show']
            ]
        );
        $this->middleware('permission:client.update|client-transfer.update' , [
            'only' => ['update']
            ]
        );
        $this->middleware('permission:client.destroy|client-transfer.destroy' , [
            'only' => ['destroy']
            ]
        );
        $this->middleware('permission:client-transfer.store' , [
            'only' => ['clientsTransfer']
            ]
        );
        $this->middleware('permission:client-transfer.update' , [
            'only' => ['clientsTransferUpdate']
            ]
        );
        $this->middleware('permission:client-transfer.destroy' , [
            'only' => ['clientsTransferDestroy']
            ]
        );
        $this->middleware('permission:client-status.update', [
            'only' => ['statusUpdate']
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchClientRules $request, UseClients $use_clients) : JsonResponse
    {
        return $use_clients->getClients($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewClientRules $request, CreateNewClient $new_client) : JsonResponse
    {
        return $new_client->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, UseClients $use_clients) : JsonResponse
    {
        if (UseCache::cacheKeyExist('client-'.$id)) {
            return $this->validateClient($id) ? ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404) : ApiResponse::success(UseCache::getCacheKey('client-'.$id),'Datos traídos de la cache');
        }

        if ($this->validateClient($id)) {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        return $use_clients->getClient($id, true, true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, UseClients $use_client, UpdateClient $update_client) : JsonResponse
    {
        if ($this->validateClient($id)) {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $validar = $this->validateData($request->all(), $id);
        if ($validar) {
            return ApiResponse::clientError(['message' => 'error en solicitud', 'errors' => $validar], 422);
        }

        $client = $use_client->getClientForUpdate($id);

        return $client ? $update_client->update($client, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, UseClients $use_client, DeleteClient $delete_client) : JsonResponse
    {
        if ($this->validateClient($id)) {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $client = $use_client->getClientForUpdate($id);

        return $client ? $delete_client->delete($client) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Método creado para transferir un cliente de orbis.net al API, posee mayor cantidad de campos a guardar.
     */
    public function clientsTransfer(TransferClientRules $request, CreateNewClient $new_client) : JsonResponse
    {
        return $new_client->transfer($request->all());
    }

    /**
     * Método creado para actualizar cliente transferido de orbis.net al API, posee mayor cantidad de campos a guardar.
     */
    public function clientsTransferUpdate(Request $request, string $id, UseClients $use_client, UpdateClient $update_client) : JsonResponse
    {
        if ($this->validateClient($id)) {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $validar = $this->validateTransferData($request->all(), $id);
        if ($validar) {
            return ApiResponse::clientError(['message' => 'error en solicitud.', 'errors' => $validar], 422);
        }

        $client = $use_client->getClientForUpdate($id);

        return $client ? $update_client->updateTransferClient($client, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Permite eliminar cualquier cliente sin importar el estado
     */
    public function clientsTransferDestroy(string $id, UseClients $use_client, DeleteClient $delete_client) : JsonResponse
    {
        if ($this->validateClient($id)) {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $client = $use_client->getClientForUpdate($id);

        return $client ? $delete_client->delete($client, true, false) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function statusUpdate(StatusUpdateRules $request, string $id, UseClients $use_client, UpdateClient $update_client) : JsonResponse
    {
        if($this->validateClient($id))
        {
            return ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
        }

        $client = $use_client->getClientForUpdate($id, false);
        
        return $client ? $update_client->statusUpdate($client, $request->all()) : ApiResponse::clientError('el recurso solicitado no se ha encontrado en el servidor', 404);
    }

    /**
     * Verifica que el id sea de un cliente
     */
    private function validateClient(string $id) : bool
    {
        $val = Validator::make(['client' => $id], [
            'client' => ['required','integer', Rule::exists('clients', 'id')],
        ]);
        
        return $val->fails();
    }

    /**
     * Verifica que los datos para actualizar cumplan con lo necesario para procesar.
     */
    private function validateData(array $input, int $id)
    {
        $validar = Validator::make(
            $input,[
                'doc_customer' => 'nullable|string|min:5|max:15|regex:/^[a-zA-Z][0-9]*$/|unique:clients,doc_customer,' . $id,
                'name' =>  'nullable|string|min:3|max:250',
                'business_address' =>  'nullable|string|min:10|max:250',
                'address_delivery' => 'nullable|string|min:10|max:250',
                'email' =>  'nullable|email|min:7|max:50|unique:clients,email,' . $id,
                'phone' => ['nullable','string','min:10','max:15', new CustomPhoneFormat],
                'state' => ['nullable','string','max:20'],
                'city' => ['nullable','string','max:20'],
                'web_customer' => ['nullable','string','max:15']
            ]
        );

        return $validar->fails() ? $validar->errors() : false;
    }

    /**
     * Verifica que los datos para actualizar cumplan con lo necesario para procesar.
     */
    private function validateTransferData(array $input, int $id)
    {
        $validar = Validator::make(
            $input,[
                'doc_customer' => 'nullable|string|min:5|max:15|regex:/^[a-zA-Z][0-9]*$/|unique:clients,doc_customer,' . $id,
                'name' =>  'nullable|string|min:3|max:250',
                'business_address' =>  'nullable|string|min:10|max:250',
                'email' =>  'nullable|email|min:7|max:50|unique:clients,email,' . $id,
                'api_status' => ['nullable','string','min:1','max:2', new CustomApiStatusValues],
                'active' => 'nullable|string|min:1|max:1|' . Rule::in(['Y', 'N']),
                'address_delivery' => 'nullable|string|min:10|max:250',
                'credit_limit' => ['nullable','numeric', new CustomCurrencyFormat],
                'state' => 'nullable|string|min:3|max:20',
                'city' => 'nullable|string|min:3|max:20',
                'phone' => ['nullable','string','min:10','max:15', new CustomPhoneFormat],
                'type_tax_1' => 'nullable|string|min:1|max:1|' . Rule::in(['0','1','2']),
                'web_customer' => 'nullable|string|max:15',
                'local_customer' => ['nullable','string','min:4','max:8', new CustomBasicCharacterFormat]
            ]
        );

        return $validar->fails() ? $validar->errors() : false;
    }
}
