<?php

	abstract class DB
	{
		public static function getAllMovies()
		{
			// requiero la conexión. Recuerden que hay una conexión instanciada en el archivo 'connection.php'. Con la palabra global le digo a php: andá y buscá en el scope global (es decir, fuera de esta función) la variable $connection. (ver archivo conecction.php y autoload.php para más claridad)
			global $connection;

			// creo la variable $stmt que hace referencia a statement, en donde voy a almacenar la query. ¿para qué nos sirven los alias en el SELECT? Recuerden que la consulta se devuelve en forma de array asociativo, es decir que lo que aparezca en el SELECT va a representar el índice del array. Por eso nos sirve ponerle el alias 'movie_id' y 'genre_id', para no confundirnos y manipular mejor los datos. Para mayor claridad, descomentar el var_dump() de abajo y abrir el archivo listado-peliculas.php desde la web
			$stmt = $connection->prepare("
				SELECT m.id AS 'movie_id', m.title, m.rating, m.awards, m.release_date, m.length, g.name AS 'genre', g.id as 'genre_id'
				FROM movies as m
				LEFT JOIN genres as g
				ON g.id = m.genre_id
				ORDER BY m.title;
			");

			// ejecuto la query
			$stmt->execute();

			// traigo la consulta en forma de array asociativo. 
			$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// var_dump($movies); exit;

			// creo un array de moviesObject, en donde vamos a almacenar objetos Movie, ¿cómo?
			$moviesObject = [];

			// recorro el array asociativo de películas que me trajo la consulta
			foreach ($movies as $movie) {
				// en la variable $finalMovie instancio una nueva película por cada vuelta del foreach. Llamo al constructor de Movie, y le paso lo que NECESITA para instanciar una película (ver constructor en la carpeta classes > Movie.php
				$finalMovie = new Movie($movie['title'], $movie['rating'], $movie['awards'], $movie['release_date']);

				// ahora hago uso de los setters que configuramos en la clase.
				$finalMovie->setId($movie['movie_id']);
				$finalMovie->setLength($movie['length']);
				$finalMovie->setGenreID($movie['genre_id']);
				$finalMovie->setGenreName($movie['genre']);

				// ahora en la variable $finalMovie tenemos un objeto Movie. Lo guardamos al final del array
				$moviesObject[] = $finalMovie;
			}

			// cuando el foreach termina de recorrer TODAS las películas de la base de datos, devuelvo el array de objetos de películas que creamos
			return $moviesObject;
		}

		public static function getAllGenres()
		{
			global $connection;

			$stmt = $connection->prepare(" SELECT id, name, ranking, active FROM genres");

			$stmt->execute();

			$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$genresObject = [];

			foreach ($genres as $genre) {
				$finalGenre = new Genre($genre['name'], $genre['ranking'], $genre['active']);

				$finalGenre->setID($genre['id']);

				$genresObject[] = $finalGenre;
			}

			return $genresObject;
		}


		public static function getAllActors()
		{
			global $connection;

			$stmt = $connection->prepare("
				SELECT a.id AS 'actor_id', a.first_name, a.last_name, a.rating, a.favorite_movie_id
				FROM actors as a
				LEFT JOIN movies as m
				ON a.favorite_movie_id = m.id
				ORDER BY a.first_name;
			");

			$stmt->execute();

			$actors = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$actorsObject = [];
			
			foreach ($actors as $actor) {
				
				$finalActor = new Actor($actor['first_name'], $actor['last_name'], $actor['rating']);
	
				$finalActor->setId($actor['actor_id']);
				$finalActor->setFavoriteMovieId($actor['favorite_movie_id']);

				$actorsObject[] = $finalActor;
			}
			
			return $actorsObject;
		}



		public static function saveMovie(Movie $movie)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					INSERT INTO movies (title, rating, awards, release_date, length, genre_id)
					VALUES(:title, :rating, :awards, :release_date, :length, :genre_id)
				");

				$stmt->bindValue(':title', $movie->getTitle());
				$stmt->bindValue(':rating', $movie->getRating());
				$stmt->bindValue(':awards', $movie->getAwards());
				$stmt->bindValue(':release_date', $movie->getReleaseDate());
				$stmt->bindValue(':length', $movie->getLength());
				$stmt->bindValue(':genre_id', $movie->getGenreID());

				$stmt->execute();

				return true;
			} catch (PDOException $exception) {
				return false;
			}
		}



		public static function saveGenre(Genre $genre)
		{
			global $connection;

			$genres = self::getAllGenres();

			$finalGenres = [];

			foreach ($genres as $oneGenre) {
				$finalGenres[] = $oneGenre->getName();
			}

			if (!in_array($genre->getName(), $finalGenres)) {
				$stmt = $connection->prepare("
					INSERT INTO genres (name, ranking, active)
					VALUES(:name, :ranking, :active)
				");

				$stmt->bindValue(':name', $genre->getName());
				$stmt->bindValue(':ranking', $genre->getRanking());
				$stmt->bindValue(':active', $genre->getActive());

				$stmt->execute();

				return true;
			} else {
				return false;
			}
		}


		public static function saveActor(Actor $actor)
		{
			global $connection;

			try {
				$stmt = $connection->prepare("
					INSERT INTO actors (first_name, last_name, rating, favorite_movie_id)
					VALUES(:first_name, :last_name, :rating, :favorite_movie_id)
				");

				$stmt->bindValue(':first_name', $actor->getFirstName());
				$stmt->bindValue(':last_name', $actor->getLastName());
				$stmt->bindValue(':rating', $actor->getRating());
				$stmt->bindValue(':favorite_movie_id', $actor->getFavoriteMovieId());

				$stmt->execute();

				return true;
			} catch (PDOException $exception) {
				return false;
			}
		}


		public static function getActorFavoriteMovie($actor)
		{
			global $connection;
			
			try {
				$stmt = $connection->prepare("
					SELECT m.title
					FROM movies as m
					WHERE id = " . $actor->getFavoriteMovieId()
				);
				
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC); 

				return $result['title'];
		
			} catch (PDOException $exception) {
				return false;
			}
		}
		
	}
