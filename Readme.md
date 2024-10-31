# Sergio Paniagua López - StackOverflow API


## Estructura del Proyecto

![image](/public/images/estructura_proyecto.png)

- **src/Controller**: `StackOverflowController`, que define los endpoints.
- **src/Service**: `StackOverflowService`, que maneja las peticiones a la API de Stack Overflow y el almacenamiento en la base de datos.
- **src/Entity**: `Query`, que corresponden a las tabla de la base de datos.
- **config/**: Contiene configuraciones de Symfony, incluyendo la configuración de la base de datos.

## Diseño de base de datos
![image](/public/images/query_table.png)

He obtado por crear una entidad Query, donde voy a almacenar en el campo questions en forma de JSON las preguntas que se obtienen de la API de Stack Overflow.

- **id**: Un identificador único para cada consulta.
- **queryString**: Cadena que representa la consulta, lo cual permite una búsqueda rápida en la base de datos.
- **questions**: Este campo almacena en formato JSON los resultados obtenidos de Stack Overflow para cada consulta específica. Decido almacenar las preguntas en un JSON ya que permite flexibilidad, evita la redundancia y facilita el almacenamiento directo de los datos.

![image](/public/images/resultado_table.png)
![image](/public/images/raw_value.png)


## Requisitos

- **Docker**: para la base de datos.
- **PHP 8.x**: recomendado para Symfony.
- **Symfony CLI** o un servidor de desarrollo como Apache/Nginx configurado para Symfony.

## Configuración

1. Clona el repositorio en tu máquina local:
   ```bash
   git clone https://github.com/sergiopani/prueba-tecnica.git
   cd /prueba-tecnica
    ```
2. Configura el archivo .env con los detalles de conexión de la base de datos:
    ```bash
    COMPOSE_PROJECT_NAME=prueba_tecnica
    MYSQL_ROOT_PASSWORD=1234
    MYSQL_DATABASE=prueba
    MYSQL_USER=sergio
    MYSQL_PASSWORD=1234
    ```
## Instalación

1. Crea el archivo ./.docker/.env.nginx.local usando ./.docker/.env.nginx como plantilla. El valor de la variable NGINX_BACKEND_DOMAIN es el server_name utilizado en NGINX.
2. Ves a ./docker y ejecuta el contenedor de MySQL
    ```bash
    docker-compose up -d
    ```
![image](/public/images/docker_ps.png)

3. Instala las dependencias de composer
    ```bash
    composer install
    ```
4. Genera la base de datos y las tablas necesarias usando migraciones:

    ```bash
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```

## Uso de los endpoints
- **Ruta**: /questions
- **Método**: GET
- **Parámetros**:
- **tagged (obligatorio)**: Etiqueta de Stack Overflow por la que se filtran las preguntas, para utilizar varias usar ;. Ejemplo: php;doctrine;javascript
- **todate (opcional)**: Fecha final, vale en formato (año-mes-dia).
- **fromdate (opcional)**: Fecha de inicio, vale en formato (año-mes-dia), tal como se indica en la url de abajo.

Ejemplo de uso:

```
http://localhost/questions?todate=2024-10-30&order=asc&fromdate=2024-10-29&sort=activity&tagged=php&site=stackoverflow

```
Resultado Imagen:
![image](/public/images/captura_api.png)
