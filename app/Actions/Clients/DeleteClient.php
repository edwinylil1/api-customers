<?php 

namespace App\Actions\Clients;

use App\Actions\Api\ApiResponse;
use App\Actions\System\cache\UseCache;
use App\Models\Clients\Client;
use App\System\ApiCustomers;
use Illuminate\Support\Facades\DB;

/**
 * Elimina un cliente de pedidos del API.
 * Métodos:
 *  * delete
 */
class DeleteClient
{
    /**
     * Delete the given client
     * Borrado del cliente
     * @param \App\Models\Clients\Client $client instancia del modelo de cliente
     * @param bool $external de ser true retorna respuesta json en false el recurso o false
     * @param bool $block de ser true no podra eliminar el registro si su estatus es T (transferido a orbis.net)
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function delete(Client $client, bool $external = true, bool $block = true)
    {
        if ($block && !in_array($client->api_status, ApiCustomers::apiStatusDeleteValues())) {
            DB::rollback();
            return $external ? ApiResponse::clientError('Intento eliminar un registro sincronizado, no tiene permisos para ello', 401) : false;
        }

        try {
            $client->delete();
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $external ? ApiResponse::serverError('No se pudo eliminar el registro, intente nuevamente') : false;
        }
        
        UseCache::cacheKeyExist('client-'.$client->id) ? UseCache::deleteKey('client-'.$client->id) : '';
        
        return $external ? ApiResponse::success(false, '', 204) : true;
    }
}
?>