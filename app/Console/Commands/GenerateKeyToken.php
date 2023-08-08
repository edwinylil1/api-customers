<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GenerateKeyToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-key-token {user_id} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un nuevo token para el API, elimina el anterior';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = $this->argument('user_id');
        $password = $this->argument('password');

        try {
            $update_user = User::where('user_id', $user)->first();
            if (isset($update_user->id)) {
                if (Hash::check($password, $update_user->password)) {
                    try {
                        if ($update_user->tokens()->exists()) {
                            $update_user->tokens()->delete();
                            $this->info('Se elimino el token anterior al generado');
                        }
                        $this->info($update_user->createToken('auth_token')->plainTextToken);
                    } catch (\Throwable $th) {
                        //throw $th;
                        $this->info('No se pudo crear el token, mensaje: ' . $th->getMessage());
                    }
                } else {
                    $this->info("la contraseña del usuario $user es incorrecta");
                }
            } else {
                $this->info("el usuario $user no existe");
            }
            
        } catch (\Throwable $th) {
            $this->info('No se pudo procesar, mensaje: ' . $th->getMessage());
        }
    }
}
