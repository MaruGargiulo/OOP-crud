<?php

// ¿porqué autoload? Porque en este archivo voy a requerir TODAS las clases del sistema. Por otro lado, al archivo 'autoload.php' lo voy a requerir una sola vez por cada página. 

// ojo con el orden que requieren las clases. En este caso la clase DB usa tanto al archivo conenection.php como a las clases Genre y Movie, por lo tanto tiene que ir al final. Técnicamente se dice que la clase DB tiene que conocer a las otras clases para poder actuar, por eso se deben cargar arriba de todo, para que ESE código cargue antes.

// piensen a los require/include como un 'copiar-pegar' virtual. Es decir, para que la clase DB use la conexión que instanciamos, tiene que tener acceso a esa variable. Eso lo logramos requiriendo archivos y logrando que "se conozcan" en un miso archivo.

	require_once 'classes/connection.php';
	require_once 'classes/Movie.php';
	require_once 'classes/Genre.php';
	require_once 'classes/Actor.php';
	require_once 'classes/DB.php';
