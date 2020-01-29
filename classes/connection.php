<?php

// en este archivo creo la conexión a la base de datos. Van a tener que configurar el $user y $pass según corresponda en la pc de cada uno/a de ustedes.

	$user = 'root';
	$pass = '';

	try {
		// en la variable $connection guardo la instancia de PDO. ¿Y PDO que me devuelve? Un objeto PDO que respresenta la conexión a la DB, a la que le voy a poder hacer todas las consultas. Listo, en esta variable va a vivir nuestra conexión (ver archivo autoload.php)
		$connection = new PDO(
			// string estandar que configuramos según el caso, aclarando el host y el nombre de la base de datos a la que me estoy queriendo conectar
			"mysql:host=localhost; dbname=movies_db; charset=utf8mb4",
			$user,
			$pass,
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	} catch (PDOException $exception) {
		// si algo falla, imprimo el mensaje en pantalla
		echo $exception->getMessage();
	}
