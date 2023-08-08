<?php

namespace App\Actions\System\users;

use App\Actions\Api\ApiResponse;
use App\Http\Traits\Forms\StringTrait;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;

/**
 * Clase para crear nuevos usuarios desde el mantenimiento en la web,la pueden usar usuarios verificados, autorizados
 * @method create(array $input) metodo para crear usuario
 */
class CreateNewUser
{
    use StringTrait;
    /**
     * Recibe los datos de usuario, si es el modelo User es una instancia de MustVerifyEmail, envia una
     * notificación de confirmación de cuenta por correo
     * @param array $input datos del usuario
     * @return mixed
     */
    public function create(array $input, bool $external = true)
    {
        try {
            $new_user = User::create([
                'user_id' => $this->extractString(trim($input['user_id']), false, ' '),
                'name' => trim($input['name']),
                'dni' => trim($input['dni']),
                'email' => trim($input['email']),
                'password' => Hash::make($input['password']),
                'country' => isset($input['country']) ? trim($input['country']) : '',
                'state' => isset($input['state']) ? trim($input['state']) : '',
                'address' => isset($input['address']) ? trim($input['address']) : '',
                'telephone' => isset($input['telephone']) ? trim($input['telephone']) : '',
            ]);

            if($new_user instanceof MustVerifyEmail){
                try {
                    $new_user->sendEmailVerificationNotification();
                } catch (\Throwable $th) {
                    //dd($th->getMessage());
                    // hay que definir metodo para enviar el error como notificación al correo
                }
            }

            if ($new_user && isset($input['roles'])) {
                switch ($input['roles']) {
                    case false:
                    case 0:
                    case '0':
                        $this->sendRole($new_user, 'cliente');
                        break;
                    
                    default:
                        $this->sendRole($new_user, trim($input['roles']));
                        break;
                }
            }

            return $external ? ApiResponse::success($new_user) : $new_user;

        } catch (\Throwable $exception) {
            // hay que definir metodo para enviar el error como notificación al correo
            //return $exception->getMessage();
            return $external ? ApiResponse::serverError('No se pudo realizar el registro, intente nuevamente') : false;
        }
    }

    /**
     * Asigna el rol pasado al cliente
     * por defecto asigna el rol cliente
     */
    private function sendRole(User $user, string $input, bool $external = true)
    {
        try {
            $user->assignRole($input);
        } catch (\Throwable $th) {
            return $external ? ApiResponse::serverError('Se creo el usuario, pero no se pudo establecer su grupo de acceso, edite el usuario creado: ' . $user) : false;
        }
    }

    public function generateApiKey(User $user, bool $external = true)
    {
        try {
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (\Throwable $th) {
            //throw $th;
            return $external ? ApiResponse::serverError('No se pudo generar su token de acceso, intente nuevamente') : false;
        }

        return $external ? ApiResponse::success($token, 'token de acceso generado, guardelo ya que no se volvera a mostrar') : $token;
    }
}

?>