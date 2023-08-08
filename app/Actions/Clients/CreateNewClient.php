<?php 

namespace App\Actions\Clients;

use App\Actions\Api\ApiResponse;
use App\Http\Traits\Forms\StringTrait;
use App\Models\Clients\Client;

/**
 * Permite crear nuevos clientes.
 * Métodos:
 *  * create
 *  * transfer
 */
class CreateNewClient
{
    use StringTrait;

    /**
     * Recibe los datos del cliente
     * @param array $input datos del cliente
     * @param bool $external si va a generar respuesta json
     * @return mixed json del recurso creado o el recurso
     */
    public function create(array $input, bool $external = true)
    {
        $new_client = [ 
            'doc_customer' => trim($input['doc_customer']),
            'name' =>  trim($input['name']),
            'business_address' =>  trim($input['business_address']),
            'address_delivery' =>  isset($input['address_delivery']) ? trim($input['address_delivery']) : null,
            'state' =>  isset($input['state']) ? trim($input['state']) : null,
            'city' =>  isset($input['city']) ? trim($input['city']) : null,
            'web_customer' =>  isset($input['web_customer']) ? trim($input['web_customer']) : null,
            'email' =>  trim($input['email']),
            'phone' => isset($input['phone']) ? trim($input['phone']) : null,
        ];

        return $this->register($new_client, $external);
    }

    /**
     * Recibe los datos del cliente a transferir de Orbis.net al API
     * @param array $input datos del cliente
     * @param bool $external si va a generar respuesta json
     * @return mixed json del recurso creado o el recurso
     */
    public function transfer(array $input, bool $external = true)
    {
        $new_client = [ 
            'doc_customer' => trim($input['doc_customer']),
            'name' =>  trim($input['name']),
            'business_address' =>  trim($input['business_address']),
            'email' =>  trim($input['email']),
            'phone' => isset($input['phone']) ? trim($input['phone']) : null,
            'api_status' => '1',
            'active' => isset($input['active']) ? $input['active'] : null,
            'address_delivery' => isset($input['address_delivery']) ? $input['address_delivery'] : null,
            'credit_limit' => isset($input['credit_limit']) ? $input['credit_limit'] : null,
            'state' => isset($input['state']) ? $input['state'] : null,
            'city' => isset($input['city']) ? $input['city'] : null,
            'type_tax_1' => isset($input['type_tax_1']) ? $input['type_tax_1'] : '0',
            'web_customer' => isset($input['web_customer']) ? $input['web_customer'] : null,
            'local_customer' => isset($input['local_customer']) ? $input['local_customer'] : null,
        ];

        return $this->register($new_client, $external);
    }

    /**
     * Realiza el registro del cliente
     * @param array $input datos del cliente
     * @param bool $external si va a generar respuesta json
     * @return mixed json del recurso creado o el recurso
     */
    protected function register(array $input, bool $external)
    {
        try {
            $new_client = Client::create($input);
            return $external ? ApiResponse::success($new_client, 'cliente registrado') : $new_client;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo realizar el registro, intente nuevamente') : false;
        }
    }
}
?>