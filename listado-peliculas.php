<?php
	require_once 'autoload.php';

	$movies = DB::getAllMovies();
	

	$pageTitle = 'Listado de películas';
	require_once 'partials/head.php';
	require_once 'partials/navbar.php';
?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<table class="table table-striped">
						<thead class="thead-dark">
			    			<tr>
								<th scope="col">Título</th>
								<th scope="col">Rating</th>
								<th scope="col">Premios</th>
								<th scope="col">Fecha lanzamiento</th>
								<th scope="col">Duración</th>
								<th scope="col">Género</th>
			    			</tr>
			  			</thead>
			  			<tbody>
							<?php foreach ($movies as $movie): ?>
								<tr>
									<th scope="row"><?php echo $movie->getTitle(); ?></th>
									<td><?php echo $movie->getRating(); ?></td>
									<td><?php echo $movie->getAwards(); ?></td>
									<td><?php echo substr($movie->getReleaseDate(), 0, 10); ?></td>
									<td><?php echo round($movie->getLength() / 60) . ' hs'; ?></td>
									<td><?php echo $movie->getGenreName(); ?></td>
								</tr>
							<?php endforeach; ?>
			  			</tbody>
					</table>
				</div>
			</div>
		</div>

	</body>
</html>
