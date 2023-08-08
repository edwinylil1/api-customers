<?php 

namespace App\Actions\Clients;

use App\Actions\Api\ApiResponse;
use App\Actions\System\cache\UseCache;
use App\Http\Traits\Forms\StringTrait;
use App\Models\Clients\Client;
use App\System\ApiCustomers;
use Illuminate\Support\Facades\DB;

/**
 * Creado para actualizar las propiedades de clientes en pedidos.
 * Métodos:
 *  * update
 *  * updateTransferClient
 */
class UpdateClient
{

    use StringTrait;
    /**
     * Update the given client
     * Editar un cliente, creado para clientes del API.
     * @param $client instancia del modelo de cliente
     * @param array $input datos para actualizar
     * @param bool $external de ser true retorna respuesta json en false el recurso o false
     * @param bool $block de ser true no podra eliminar el registro si su estatus es T (transferido a orbis.net)
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function update(Client $client, array $input, bool $external = true, bool $block = true)
    {
        if (!isset($input['doc_customer']) && !isset($input['name']) && !isset($input['business_address']) && !isset($input['email']) && !isset($input['phone']) && !isset($input['address_delivery']) && !isset($input['state']) && !isset($input['city']) && !isset($input['web_customer'])) {
            DB::rollback();
            return ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación');
        }

        if ($block && !in_array($client->api_status, ApiCustomers::apiStatusUpdateValuesTwo())) {
            DB::rollback();
            return $external ? ApiResponse::clientError('Intento editar un registro sincronizado, no tiene permisos para ello', 401) : false;
        }

        try {

            $client->doc_customer = isset($input['doc_customer']) ? trim($input['doc_customer']) : $client->doc_customer;
            $client->name = isset($input['name']) ?  trim($input['name']) : $client->name;
            $client->business_address = isset($input['business_address']) ?  trim($input['business_address']) : $client->business_address;
            $client->address_delivery = isset($input['address_delivery']) ?  trim($input['address_delivery']) : $client->address_delivery;
            $client->email = isset($input['email']) ?  trim($input['email']) : $client->email;
            $client->phone = isset($input['phone']) ? trim($input['phone']) : $client->phone;
            $client->state =  isset($input['state']) ? trim($input['state']) : $client->state;
            $client->city =  isset($input['city']) ? trim($input['city']) : $client->city;
            $client->web_customer =  isset($input['web_customer']) ? trim($input['web_customer']) : $client->web_customer;
            $client->api_status = '5';
            $client->save();
            DB::commit();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $external ? ApiResponse::serverError('No se pudo actualizar el registro, intente nuevamente') : false;
        }

        UseCache::cacheKeyExist('client-'.$client->id) ? UseCache::deleteKey('client-'.$client->id) : '';

        return  $external ? ApiResponse::success(false, '', 204) : true;
    }

    /**
     * Update the given client
     * Editar un cliente, creado para comsisa, permite editar todo.
     * @param $client instancia del modelo de cliente
     * @param bool $external de ser true retorna respuesta json en false el recurso o false
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function updateTransferClient(Client $client, array $input, bool $external = true)
    {
        if (!isset($input['doc_customer']) && !isset($input['name']) && !isset($input['business_address']) && !isset($input['email']) && !isset($input['phone']) && !isset($input['api_status']) && !isset($input['active']) && !isset($input['address_delivery']) && !isset($input['credit_limit']) && !isset($input['state']) && !isset($input['city']) && !isset($input['type_tax_1']) && !isset($input['web_customer']) && !isset($input['local_customer'])) {
            DB::rollback();
            return ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación');
        }

        try {

            $client->doc_customer = isset($input['doc_customer']) ? $input['doc_customer'] : $client->doc_customer;
            $client->name = isset($input['name']) ? $input['name'] : $client->name;
            $client->business_address = isset($input['business_address']) ? $input['business_address'] : $client->business_address;
            $client->email = isset($input['email']) ? $input['email'] : $client->email;
            $client->phone = isset($input['phone']) ? $input['phone'] : $client->phone;
            $client->api_status = isset($input['api_status']) ? $input['api_status'] : '2';
            $client->active = isset($input['active']) ? $input['active'] : $client->active;
            $client->address_delivery = isset($input['address_delivery']) ? $input['address_delivery'] : $client->address_delivery;
            $client->credit_limit = isset($input['credit_limit']) ? $input['credit_limit'] : $client->credit_limit;
            $client->state = isset($input['state']) ? $input['state'] : $client->state;
            $client->city = isset($input['city']) ? $input['city'] : $client->city;
            $client->type_tax_1 = isset($input['type_tax_1']) ? $input['type_tax_1'] : $client->type_tax_1;
            $client->web_customer = isset($input['web_customer']) ? $input['web_customer'] : $client->web_customer;
            $client->local_customer = isset($input['local_customer']) ? $input['local_customer'] : $client->local_customer;
            $client->save();
            DB::commit();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $external ? ApiResponse::serverError('No se pudo actualizar el registro, intente nuevamente') : false;
        }

        UseCache::cacheKeyExist('client-'.$client->id) ? UseCache::deleteKey('client-'.$client->id) : '';

        return  $external ? ApiResponse::success(false, '', 204) : true;
    }


    /**
     * Update the given client
     * Editar un cliente, creado para clientes del API.
     * @param $client instancia del modelo de cliente
     * @param array $input datos para actualizar
     * @param bool $external de ser true retorna respuesta json en false un bool
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function statusUpdate(Client $client, array $input, bool $external = true)
    {
        if (!isset($input['api_status'])) {
            DB::rollback();
            return ApiResponse::clientError('Su solicitud del cliente es incorrecta o incompleta, revise la documentación');
        }
        if ($input['api_status'] == $client->api_status) {
            DB::rollback();
            return ApiResponse::clientError('Su estado ya fue confirmado en una solicitud anterior');
        }

        if (isset($input['api_status']) && !in_array($client->api_status, ApiCustomers::apiStatusSync())) {
            DB::rollback();
            return $external ? ApiResponse::clientError('El estado actual del recurso no permite marcarlo como sincronizado.', 401) : false;
        }

        try {
            $client->api_status = $input['api_status'];
            $client->save();
            DB::commit();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $external ? ApiResponse::serverError('No se pudo actualizar el registro, intente nuevamente') : false;
        }
        
        UseCache::cacheKeyExist('client-'.$client->id) ? UseCache::deleteKey('client-'.$client->id) : '';

        return  $external ? ApiResponse::success(false, '', 204) : true;
    }
}
?>