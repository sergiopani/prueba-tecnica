# Proyecto Symfony StackOverflow API

Este proyecto es una API en Symfony que interactúa con la API pública de Stack Overflow. Permite obtener datos sobre preguntas de los foros de Stack Overflow con ciertos filtros y almacena las consultas en una base de datos.

## Estructura del Proyecto

![image](/public/images/estructura_proyecto.png)

- **src/Controller**: Contiene los controladores de la aplicación, incluyendo el controlador `StackOverflowController`, que define los endpoints.
- **src/Service**: Incluye los servicios que realizan la lógica de negocio, como `StackOverflowService`, que maneja las peticiones a la API de Stack Overflow y el almacenamiento en la base de datos.
- **src/Entity**: Define las entidades `Query`, que corresponden a las tablas de la base de datos.
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
   git clone https://github.com/tu-usuario/proyecto-symfony-stackoverflow.git
   cd proyecto-symfony-stackoverflow
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
1. Inicia Docker y ejecuta el contenedor de MySQL
    ```bash
    docker-compose up -d
    ```
2. Instala las dependencias de composer
    ```bash
    composer install
    ```
3. Genera la base de datos y las tablas necesarias usando migraciones:

    ```bash
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```

## Uso de los endpoints
Ruta: /questions
Método: GET
Parámetros:
tagged (obligatorio): Etiqueta de Stack Overflow por la que se filtran las preguntas.
todate (opcional): Fecha final en formato UNIX timestamp.
fromdate (opcional): Fecha de inicio en formato UNIX timestamp.

Ejemplo de uso:
```
http://localhost/questions?todate=2024-10-30&order=asc&fromdate=2024-10-29&sort=activity&tagged=php&site=stackoverflow

```
Resultado Imagen:
![image](/public/images/captura_api.png)
