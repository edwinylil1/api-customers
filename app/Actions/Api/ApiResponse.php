<?php

namespace App\Actions\Api;

/**
 * Clase que maneja las respuestas del API para los metodos de los recursos.
 */
class ApiResponse 
{
    /**
     * Empleado para mensajes informativos de respuesta json
     */
    protected function info($data, $status)
    {
        /**
         * 100 (Continue): Indica que el servidor ha recibido la solicitud y que el cliente puede 
         * continuar enviando el resto de la solicitud
         * 101 (Switching Protocols): Indica que el servidor está cambiando a un protocolo diferente, 
         * como por ejemplo, cambiando de HTTP a WebSocket
         * 102 (Processing): Indica que el servidor ha recibido y está procesando la solicitud, 
         * pero aún no ha completado la respuesta
         * 103 (Early Hints) es un código de estado experimental que se utiliza para indicar 
         * al cliente que el servidor está procesando la solicitud y que se enviarán más información 
         * y encabezados en breve. Este código de estado se puede utilizar para mejorar el rendimiento de 
         * la aplicación, ya que permite al servidor enviar anticipadamente información relevante para el cliente 
         * mientras se está procesando la respuesta completa.
         */

    }

    /**
     * Empleado para mensajes satisfactorios de respuesta json
     */
    public static function success($data, $message = '', int $status = 200, array $headers = [], $options = 0)
    {
        /**
         * 200 (OK): Indica que la solicitud se ha procesado correctamente y que se ha enviado una 
         * respuesta con los datos solicitados.
         * 201 (Created): Indica que se ha creado un nuevo recurso a partir de la solicitud del cliente,
         *  como por ejemplo, un nuevo registro en una base de datos.
         * 202 (Accepted): Indica que la solicitud se ha aceptado para su procesamiento, pero aún no se ha completado.
         * 204 (No Content): Indica que la solicitud se ha procesado correctamente,
         * pero que no se ha enviado ningún contenido en la respuesta.
         * 
         * 205 (Reset Content): Indica que la solicitud se ha procesado correctamente, pero que el cliente debe 
         * restablecer la vista que está mostrando actualmente.
         * 206 (Partial Content): Indica que la respuesta es solo una parte de la respuesta completa, ya que 
         * la solicitud del cliente incluyó una solicitud de rango de datos específicos.
         * 207 (Multi-Status): Indica que la respuesta contiene información sobre el estado de varios recursos, 
         * como por ejemplo, en una solicitud de múltiples operaciones.
         * 208 (Already Reported): Indica que la respuesta es un informe de resultados previamente informados, 
         * por ejemplo, en una solicitud para obtener el estado de una operación de procesamiento en segundo plano.
         * 226 (IM Used): Indica que el servidor ha completado una solicitud para el recurso, y que la respuesta 
         * es una representación de la instancia del recurso tal como se ha modificado por la solicitud.
         */
        return response()->json([
            'message' => $message,
            'data' => $data ? $data : '',
         ], $status, $headers, $options);
    }

    /**
     * Empleado para mensajes de redirección de respuesta json
     */
    protected function redirect($data, $status)
    {
        /**
         * 300 (Multiple Choices): Indica que la solicitud tiene múltiples respuestas posibles, y que el servidor
         *  proporciona una lista de opciones para que el cliente elija.
         * 301 (Moved Permanently): Indica que la solicitud se ha redirigido permanentemente a una nueva URL, y
         *  que los clientes deben actualizar sus marcadores y enlaces a la nueva URL.
         * 302 (Found): Indica que la solicitud se ha redirigido temporalmente a una nueva URL, y que los 
         * clientes deben continuar usando la URL original en el futuro.
         * 303 (See Other): Indica que la respuesta a la solicitud se puede encontrar en una URL diferente, y 
         * que los clientes deben utilizar la nueva URL para obtener la respuesta.
         * 304 (Not Modified): Indica que la versión en caché de la respuesta del cliente sigue siendo válida, y 
         * que el servidor no necesita enviar una respuesta completa.
         */
        
    }


    /**
     * Empleado para mensajes por errores del cliente de respuesta json
     */
    public static function clientError($message, int $status = 400, array $headers = [])
    {
        /**
         * 400 (Bad Request): Indica que la solicitud del cliente es incorrecta o incompleta, y que el servidor 
         * no puede procesarla.
         * 401 (Unauthorized): Indica que el cliente debe autenticarse para obtener acceso al recurso solicitado.
         * 403 (Forbidden): Indica que el servidor ha entendido la solicitud del cliente, pero se niega a cumplirla
         * debido a restricciones de acceso o permisos insuficientes.
         * 404 (Not Found): Indica que el recurso solicitado no se ha encontrado en el servidor.
         */
        if ($status == 422) {
            return response()->json([
                'message' => $message['message'],
                'errors' => $message['errors']
             ], $status, $headers);
        }
        
        return response()->json([
            'message' => $message
         ], $status, $headers);
    }

    /**
     * Empleado para mensajes por errores en servidor de respuesta json
     */
    public static function serverError(string $message, int $status = 500, array $headers = [])
    {
        /**
         * 500 (Internal Server Error): Indica que se ha producido un error interno en el servidor, lo que 
         * significa que el servidor no puede completar la solicitud del cliente.
         * 501 (Not Implemented): Indica que el servidor no puede completar la solicitud del cliente porque 
         * no reconoce o admite el método de solicitud utilizado en la solicitud.
         * 502 (Bad Gateway): Indica que el servidor, como puerta de enlace, ha recibido una respuesta no válida
         * del servidor de origen al intentar cumplir con la solicitud del cliente.
         * 503 (Service Unavailable): Indica que el servidor no está disponible temporalmente para manejar la 
         * solicitud del cliente debido a una sobrecarga o mantenimiento.
         * 504 (Gateway Timeout): Indica que el servidor, como puerta de enlace, no ha recibido una respuesta 
         * oportuna del servidor de origen al intentar cumplir con la solicitud del cliente.
         * 
         * 505 (HTTP Version Not Supported): Indica que el servidor no admite la versión del protocolo HTTP utilizada 
         * en la solicitud del cliente.
         * 506 (Variant Also Negotiates): Indica que el servidor ha detectado una referencia circular en las negociaciones 
         * de contenido y no puede cumplir con la solicitud del cliente.
         * 507 (Insufficient Storage): Indica que el servidor no puede cumplir con la solicitud del cliente porque
         * no tiene suficiente espacio de almacenamiento disponible.
         * 508 (Loop Detected): Indica que el servidor ha detectado un bucle infinito mientras procesa la solicitud
         * del cliente.
         * 510 (Not Extended): Indica que la solicitud del cliente requiere una extensión adicional que el servidor
         * no admite.
         * 511 (Network Authentication Required): Indica que el cliente debe autenticarse para obtener acceso a la
         * red, como por ejemplo, en una red Wi-Fi pública.
         */

         return response()->json([
            'message' => $message
         ], $status, $headers);
        
    }
}

?>