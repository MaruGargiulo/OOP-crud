## Orden sugerido para leer los archivos

Empezar por la carpeta 'classes'.
En esta carpeta están todas las clases del sistema y la conexión. ¿Porqué la conexión? Porque es una de las formas en las que se puede encarar el armado del sistema. Instanciamos la conexión UNA SOLA VEZ en este archivo. Luego, requerimos esa conexión donde haga falta, en este caso, en la clase DB.php

*¿Por qué?*

> Porque la clase DB.php **usa** esa conexión para hacer todas las consultas a la base de datos: "traeme todas las películas", "traeme el nombre de este género", "guardame esta peli nueva", etc.


## Cómo mejorar el sistema

- Sería ideal no tener la conexión a la base de datos en un archivo separado. Un posible camino sería agregarle un método estático a la clase DB.

*¿Para qué serviría esto?*

Para "emprolijar el código". Ya no tendría la conexión suelta, si no que sería parte del contexto de una clase. No es necesario, pero al estar programando con el paradigma de objetos, se hace 'casi' necesario.

> Algo importante a tener en cuenta es que, **nada** es obligatorio en este paradigma. Nadie está monitoreando que estas reglas se cumplan (salvo en un equipo de trabajo en el que se haya establecido esta forma de desarrollo, tal vez). Este paradigma llega para encarar la programación desde otro lado.


## Cómo podría quedar ese método

`DB.php`

```php
abstract class DB
{
    static function connection($host, $dbname, $user, $pass)
    {
        return new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
```

*¿Y de qué me sirve pasarle parámetros a este método?*

> Puede que en mi sistema quiera tener más de una conexión activa. Configurando el método connection()con algunos datos como variables, puedo instanciar dps conexiones en dos hosts y bases de datos diferentes, por ejemplo.

```php
// en $dbMovies tenemos la conexión con la base de datos movies_db que vive en localhost, que es lo mismo que poner 127.0.0.1 que es la dirección ip local de la pc
$dbMovies = DB::connection('localhost', 'movies_db', 'root', '');

// en $dbCatalogo tenemos la conexión con la base de datos catalogo que vive en otra dirección ip
$dbCatalogo = DB::connection('12.345.23', 'catalogo', 'gino', '123');
```

## Cómo asegurarme que la conexión no falle

Para atrapar cualquier posible error en la conexión, podemos incorporar el try/catch en cada instancia de PDO que necesitemos:

```php
try {
    $dbMovies = DB::connection('localhost', 'movies_db', 'root', '');
} catch(PDOException $e) {
    echo $e->getMessage();
}

try {
    $dbCatalogo = DB::connection('12.345.23', 'catalogo', 'gino', '123');
} catch(PDOException $e) {
    echo $e->getMessage();
}
```

: : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : : 


- Para ir un paso más allá, podríamos definir que la clase DB **únicamente** tenga el método estático para conectarse, y migrar todos sus otros métodos a las clases correspondientes.

*¿Por qué?*

> Porque en este contexto estamos entendiendo a cada clase como una futura entidad: Movie, Genre, Actor. Por lo tanto, cada entidad debería saber y poder: guardarse, listarse, mostrarse y eliminarse --> CRUD

## SPOILER ALERT

- Falta poco para conocer lo que es el patrón MVC, que hace referencia a Modelo - Vista - Controlador.
Cuando lleguemos a eso se va a ordenar MUCHO todo lo que vieron en programación orientada a objetos, porque lo van a ver en el contexto de Laravel, que es una maravilla.



