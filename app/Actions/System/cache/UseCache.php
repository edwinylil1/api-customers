<?php
namespace App\Actions\System\cache;

use App\System\ApiCustomers;
use Illuminate\Support\Facades\Cache;

/**
 * Acciones para obtener datos de la cache
 */
class UseCache
{
    /**
     * Obtiene el valor en cache
     * No se aplican etiquetas de busqueda.
     * @param string $key clave de búsqueda en la cache
     * @return mixed retorna el valor encontrado o un false
     */
    public static function getCacheKey(string $key) : mixed
    {
        if (Cache::has($key)) {
            try {
                return Cache::get($key);
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }

        return false;
    }

    /**
     * Verifica si existe la clave en cache
     * No se aplican etiquetas de busqueda.
     * @param string $key clave de búsqueda en la cache
     * @return bool retorna true si existe o un false si no
     */
    public static function cacheKeyExist(string $key) : bool
    {
        if (Cache::has($key)) {
            return true;
        }

        return false;
    }


    /**
     * Envia el valor a la cache empleada en el driver por defecto
     * Este valor permanece durante 60 minutos por defecto
     * Primero busca el valor, si no lo consigue lo manda, si lo consigue lo elimina y luego manda el nuevo
     * @param string $key valor clave de busqueda para la cache
     * @return true seguira intentando enviar el valor indefinidamente (por los momentos al 20230417)
     */
    public static function setCacheKey(string $key, $value) : bool
    {
        if (UseCache::cacheKeyExist($key)) {
            try {
                UseCache::deleteKey($key);
                Cache::put($key, $value, now()->addHours(ApiCustomers::timeInHoursCache()));
                return true;
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        } else {
            try {
                Cache::put($key, $value, now()->addHours(ApiCustomers::timeInHoursCache()));
                return true;
            } catch (\Throwable $th) {
                //throw $th;
                return false;
            }
        }
    }

    public static function deleteKey(string $key) : void
    {
        Cache::forget($key);
    }

}

?>