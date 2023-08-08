# API DE EJEMPLO PARA MANEJAR CLIENTES ENTRE MULTIPLES SISTEMAS

## Clonar

    cd /path
    
    git clone git@github.com:ruta.git path.app.lan
            
## Ingresar en carpeta
        
    cd miweb.lan
        
    git status
        
## Para instalar

    composer install 

### Crear archivo de entorno

	cp .env.example  .env

### ver que se creo

	cat .env

### Generar clave 

	php artisan key:generate

### Crear enlace a la carpeta de recursos

	php artisan storage:link
                
# Actualizar datos del archivo .env

    nano .env
        
    APP_NAME=NombreApp
    APP_ENV=local // cambiar a production luego de instalar
    APP_URL=https://midominio.app/
    APP_DEBUG=true // cambiar a false luego de instalar
    QUEUE_CONNECTION=database  // para activar las colas en la base de datos
        
# Parámetros para correo de prueba, deben crear cuenta en mailtrap para agregar su username y password

	MAIL_MAILER=smtp
	MAIL_HOST=smtp.mailtrap.io
	MAIL_PORT=2525
	MAIL_USERNAME=
	MAIL_PASSWORD=
	MAIL_ENCRYPTION=tls
	MAIL_FROM_ADDRESS=admin@admin.net
	MAIL_FROM_NAME="${APP_NAME}"
 
##### Reemplazar en el .env, los nombres de las bases de datos a usar, usuario y contraseña para correr las migraciones y crear la estructura de las tablas
    
    nano .env
       
##### Ejecutar las migraciones (esto crea las tablas)
       
    php artisan migrate
    
##### Instalar la configuración base: 
        
    php artisan db:seed 

### Crear token para el API con la cuenta por defecto

    php artisan app:generate-key-token admin admin1234
                        
### Laravel Borrar caché de aplicaciones

	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear

## Para guardar la configuración

    php artisan config:cache 
	
##  Borrar y cargar la caché de ruta de Laravel	
    
    php artisan route:cache 

## Activar la cola

    php artisan queue:work

# Actualizar en el cliente:

## Actualizar en local con los últimos cambios del repositorio

    git fetch
        
## Traer los cambios del repositorio en GIT HUB a GIT main puede ser cambiado por un branch especifico

    git pull origin main
        
## Para correr el servidor local

    php artisan serve