<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'accepted_if'          => 'El campo :attribute debe aceptarse cuando :other es :value.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'array'   => 'El campo :attribute debe contener entre :min y :max elementos.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',        
        'string'  => 'El campo :attribute debe contener entre :min y :max caracteres.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de :attribute no coincide.',
    'current_password'     => 'La contraseña es incorrecta.',
    'date'                 => 'El campo :attribute no corresponde con una fecha válida.',
    'date_equals'          => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format'          => 'El campo :attribute no corresponde con el formato de fecha :format.',
    'declined'             => 'El campo :attribute debe ser rechazado.',
    'declined_if'          => 'El campo :attribute debe ser rechazado cuando :other es :value.',
    'different'            => 'Los campos :attribute y :other deben ser diferentes.',
    'digits'               => 'El campo :attribute debe ser un número de :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe contener entre :min y :max dígitos.',
    'dimensions'           => 'El campo :attribute tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'doesnt_end_with'      => 'El campo :attribute no puede terminar con uno de los siguientes valores: :values.',
    'doesnt_start_with'    => 'El campo :attribute no puede iniciar con uno de los siguientes valores: :values.',
    'email'                => 'El campo :attribute debe ser una dirección de correo válida.',
    'ends_with'            => 'El campo :attribute debe finalizar con alguno de los siguientes valores: :values',
    'enum'                 => 'El valor seleccionado :attribute es inválido.',
    'exists'               => 'El campo :attribute seleccionado no existe.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'gt'                   => [
        'array'   => 'El campo :attribute debe contener más de :value elementos.',
        'file'    => 'El archivo :attribute debe pesar más de :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser mayor a :value.',
        'string'  => 'El campo :attribute debe contener más de :value caracteres.',        
    ],
    'gte'                  => [
        'array'   => 'El campo :attribute debe contener :value o más elementos.',
        'file'    => 'El archivo :attribute debe pesar :value o más kilobytes.',
        'numeric' => 'El campo :attribute debe ser mayor o igual a :value.',        
        'string'  => 'El campo :attribute debe contener :value o más caracteres.',
    ],
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute es inválido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'lt'                   => [
        'array'   => 'El campo :attribute debe contener menos de :value elementos.',
        'file'    => 'El archivo :attribute debe pesar menos de :value kilobytes.',
        'numeric' => 'El campo :attribute debe ser menor a :value.',        
        'string'  => 'El campo :attribute debe contener menos de :value caracteres.',
    ],
    'lte'                  => [
        'array'   => 'El campo :attribute debe contener :value o menos elementos.',
        'file'    => 'El archivo :attribute debe pesar :value o menos kilobytes.',
        'numeric' => 'El campo :attribute debe ser menor o igual a :value.',        
        'string'  => 'El campo :attribute debe contener :value o menos caracteres.',
    ],
    'mac_address'          => 'El campo :attribute debe ser una dirección MAC válida.',
    'max'                  => [
        'array'   => 'El campo :attribute no debe contener más de :max elementos.',
        'file'    => 'El archivo :attribute no debe pesar más de :max kilobytes.',
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',        
        'string'  => 'El campo :attribute no debe contener más de :max caracteres.',
    ],
    'max_digits'           => 'El campo :attribute no debe tener más de :max dígitos.',
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'array'   => 'El campo :attribute debe contener al menos :min elementos.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',        
        'string'  => 'El campo :attribute debe contener al menos :min caracteres.',
    ],
    'not_in'               => 'El campo :attribute seleccionado es inválido.',
    'not_regex'            => 'El formato del campo :attribute es inválido.',
    'numeric'              => 'El campo :attribute debe ser un número.',
    'password'             => [
        'letters' => 'El campo :attribute debe contener al menos una letra.',
        'mixed'   => 'El campo :attribute debe contener al menos una letra mayúscula y una minúscula.',
        'numbers' => 'El campo :attribute debe contener al menos un número.',
        'symbols' => 'El campo :attribute debe contener al menos un símbolo.',
        'uncompromised' => 'El valor de :attribute ha aparecido en una fuga de datos. Por favor, modifique su :attribute.',
    ],
    'present'              => 'El campo :attribute debe estar presente.',
    'prohibited'           => 'El campo :attribute esta prohibido.',
    'prohibited_if'        => 'El campo :attribute está prohibido cuando el campo :other es :value.',
    'prohibited_unless'    => 'El campo :attribute está prohibido a menos que :other este en :values.',
    'prohibits'            => 'El campo :attribute se prohíbe cuando :other debe estar presente.',
    'regex'                => 'El formato del campo :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_array_keys'  => 'El campo :attribute debe contener al menos: :values entradas.',
    'required_if'          => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_unless'      => 'El campo :attribute es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los campos :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'array'   => 'El campo :attribute debe contener :size elementos.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'numeric' => 'El campo :attribute debe ser :size.',        
        'string'  => 'El campo :attribute debe contener :size caracteres.',
    ],
    'starts_with'          => 'El campo :attribute debe comenzar con uno de los siguientes valores: :values',
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El campo :attribute debe ser una zona horaria válida.',
    'unique'               => 'El valor del campo :attribute ya está en uso.',
    'uploaded'             => 'El campo :attribute no se pudo subir.',
    'url'                  => 'El formato del campo :attribute es inválido.',
    'uuid'                 => 'El campo :attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
            'currency_format' => 'El campo :attribute debe tener un formato de moneda válido.',
            'rate_format' => 'El campo :attribute debe tener un formato de tasa válido.',
            'weight_format' => 'El campo :attribute debe tener un formato de peso válido.',
            'basic_character_format' => 'El campo :attribute debe contener solo letras y números sin tildes.',
            'nid_format' => 'El campo :attribute debe comenzar con una letra y contener solo números y letras sin tildes.',
            'phone_format' => 'El campo :attribute no es un número aceptado.',
            'api_status' => 'El campo :attribute no tiene un valor aceptado.',
            'numbers_only_format' => 'El campo :attribute debe contener solo números enteros positivos.'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'        => 'nombre',
        'password'    => 'contraseña',
        'address'     => 'dirección',
        'userid'      => 'usuario',
        'user_id'      => 'usuario',
        'lyrics'      => 'letra',
        'number'      => 'número',
        'name2'       => 'segundo nombre',
        'lastName'    => 'apellido',
        'lastname'    => 'apellido',
        'last name'   => 'apellido',        
        'lastName2'   => 'segudo apellido',        
        'lastname2'   => 'segudo apellido',
        'last name2'  => 'segudo apellido',
        'country'     => 'pais',
        'state'       => 'estado',
        'group'       => 'grupo',
        'city'        => 'ciudad',
        'postalCode'  => 'código postal',
        'postalcode'  => 'código postal',
        'postal code' => 'código postal',
        'phone'       => 'teléfono',
        'telephone'   => 'teléfono',
        'mobilePhone' => 'teléfono móvil',
        'mobilephone' => 'teléfono móvil',        
        'locked'      => 'bloqueado',
        'affiliate'   => 'afiliado',
        'connection'  => 'conexión',
        'queue'       => 'cola',
        'payload'     => 'carga',
        'exception'   => 'excepción',
        'failed_at'   => 'falló en',
        'company'     => 'empresa',
        'system'      => 'sistema',
        'parameter'   => 'parámetro',
        'description' => 'descripción',
        'value'       => 'valor',
        'image'       => 'imagen',
        'imgfor'      => 'imagen para',        
        'fullAcces'   => 'acceso completo',
        'fullacces'   => 'acceso completo',
        'full acces'  => 'acceso completo',
        'method'      => 'método',
        'product'     => 'producto',
        'created_at'  => 'creado en',
        'delete_at'   => 'borrado en',
        'auxiliary'   => 'auxiliar',
        'updated_at'  => 'actualizado en',
        'encryption'  => 'cifrado',
        'hidden'      => 'oculto',
        'online'      => 'en línea',
        'connections' => 'conexiones',
        'status'      => 'estado',
        'file'        => 'archivo',
        'fileable_id' => 'identificación de archivo',        
        'attempts'    => 'intentos',        
        'confirm'     => 'confirmar',
        'clientdni'   => 'documento del cliente',
        'nid'         => 'documento de identidad nacional',
        'payment'     => 'pago',
        'quantity'    => 'cantidad',
        'registered'  => 'registrado',
        'uploadpdf'   => 'cargar pdf',
        'municipality'      => 'municipio',
        'mobile phone'      => 'teléfono móvil',        
        'imageable_id'      => 'identificación de imagen',
        'fileable_type'     => 'tipo de archivo',
        'imageable_type'    => 'tipo de imagen',        
        'deliveryaddress'   => 'dirección de entrega',
        'deliveryAddress'   => 'dirección de entrega',
        'delivery address'  => 'dirección de entrega',
        'current_password'  => 'contraseña actual',
        'barcode'           => 'código de barras',
        'qrcode'            => 'código Qr',
        'unit'              => 'unidad de medida',
        'line'              => 'línea',
        'type_tax_1'        => 'tipo de tasa 1',
        'stock'             => 'existencia',
        'weight'            => 'peso',
        'active'            => 'activo',
        'price_1'           => 'precio 1',
        'price_2'           => 'precio 2',
        'price'             => 'precio',
        'doc_customer'      => 'documento del cliente',
        'address_fiscal'    => 'dirección fiscal',
        'business_address'  => 'dirección de negocios',
        'code'              => 'código',
        'account_number'    => 'número de cuenta',
        'owner'             => 'dueño',
        'bank_code'         => 'código del banco',
        'value_foreign'     => 'valor extranjero',
        'products'          => 'productos',
        'payments'          => 'pagos'
    ],

];
