<?php 

namespace App\Actions\Clients;

use App\Actions\Api\ApiResponse;
use App\Actions\System\cache\UseCache;
use App\Models\Clients\Client;
use App\System\ApiCustomers;
use Illuminate\Support\Facades\DB;

/**
 * Clase para manejar los clientes de pedidos en el API.
 * Métodos disponibles:
 *  * getClients
 *  * getClient
 *  * getClientForUpdate
 */
class UseClients
{
    /**
     * Retorna los clientes paginados
     * @param int $input array con filtros de búsqueda
     * @param string $external si va a generar respuesta json
     * @return mixed json con respuesta - lista de clientes - false
     */
    public function getClients(array $input, bool $external = true)
    {
        $email = isset($input['email']) ? $input['email'] : '';
        $name = isset($input['name']) ? $input['name'] : '';
        $dni = isset($input['doc-customer']) ? $input['doc-customer'] : '';
        $active = isset($input['active']) ? $input['active'] : '';
        $status = isset($input['api-status']) ? $input['api-status'] : '';
        $paginate = isset($input['paginate']) ? $input['paginate'] : ApiCustomers::defaultPagination();
        $data_full = isset($input['data-full']) ? true : false;

        if ($data_full) {
            try {
                $clients = Client::orderBY('name')
                    ->email($email)
                    ->name($name)
                    ->dni($dni)
                    ->active($active)
                    ->status($status)
                    ->paginate($paginate)
                    ->appends(request()->all());
            } catch (\Throwable $th) {
                //throw $th;
                return $external ? ApiResponse::serverError('error del servidor, intente mas tarde') : false;
            }

            foreach ($clients as $key) {
                if (isset($key->id)) {
                    if (in_array($key->api_status, ApiCustomers::apiStatusToUpdate())) {
                        ApiCustomers::sendStatus('clients', $key->api_status, 'id', $key->id, 'client-'.$key->id);
                    }
                }
            }

            return $external ? ApiResponse::success($clients) : $clients;
        }

        try {
            $clients = Client::select('id','doc_customer','name','email','business_address','phone','api_status')
                ->orderBY('name')
                ->email($email)
                ->name($name)
                ->dni($dni)
                ->active($active)
                ->status($status)
                ->paginate($paginate)
                ->appends(request()->all());

            return $external ? ApiResponse::success($clients) : $clients;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('error del servidor, intente mas tarde') : false;
        }
    }

    /**
     * Busca el cliente en la base de datos, si no lo consigue retorna falso.
     * @param string $client id del cliente
     * @param bool $external de ser true retorna respuesta json en false el recurso o false
     * @param bool $save_cache en true indica que debe guardar la consulta en cache, por defecto es false
     * @return mixed json con respuesta - cliente - false
     */
    public function getClient(string $client, bool $external = true, bool $save_cache = false)
    {
        try {
            $search = Client::find($client);
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo procesar, intente nuevamente') : false;
        }

        if (isset($search->id)) {

            if (in_array($search->api_status, ApiCustomers::apiStatusToUpdate())) {
                ApiCustomers::sendStatus('clients', $search->api_status, 'id', $search->id, 'client-'.$search->id);
            }

            $save_cache ? UseCache::setCacheKey('client-'.$search->id, $search) : '';
            
            return $external ? ApiResponse::success($search) : $search;
        }

        return $external ? ApiResponse::clientError('este recurso no se ha encontrado en el servidor', 404) : false;
    }

    /**
     * Obtiene un recurso cliente bloqueando el recurso en la db
     * @param string $id id del recurso
     * @return mixed json con respuesta - cliente - false
     */
    public function getClientForUpdate(string $id)
    {
        try {
            DB::beginTransaction();
            $client = Client::lockForUpdate()->find($id);

            if (isset($client->id)) {
                return $client;
            }

            DB::rollBack();
            return false;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return false;
        }
    }
}
?>